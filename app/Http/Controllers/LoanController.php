<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Menampilkan halaman peminjaman barang
     */
    public function index()
    {
        $items = Item::where('stock', '>', 0)->get();
        $loans = Loan::with(['user', 'item', 'fines'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('pinjamBarang', compact('items', 'loans'));
    }

    /**
     * Menampilkan riwayat transaksi pengembalian
     */
    public function transactions()
    {
        $loans = Loan::with(['user', 'item', 'fines'])
            ->whereIn('status', ['returned', 'borrowed'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('transactions', compact('loans'));
    }

    /**
     * Proses peminjaman barang
     */
    public function borrow(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'purpose' => 'required|string|max:500',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
        ]);

        $item = Item::findOrFail($request->item_id);

        if ($item->stock < $request->quantity) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi! Stok tersedia: ' . $item->stock . ' unit'
                ], 400);
            }
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        try {
            DB::beginTransaction();

            $loan = Loan::create([
                'user_id' => Auth::id(),
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'purpose' => $request->purpose,
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
                'status' => 'pending',
                'loan_date' => now(),
            ]);

            DB::commit();

            $message = 'Peminjaman berhasil diajukan! Menunggu persetujuan petugas.';
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => $loan
                ]);
            }

            return redirect()->route('pinjamBarang')->with('success', $message);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Proses peminjaman barang (alternatif)
     */
    public function borrowItem(Request $request)
    {
        return $this->borrow($request);
    }

    /**
     * Menyetujui peminjaman
     */
    public function approve($id)
    {
        $loan = Loan::findOrFail($id);
        
        if ($loan->status != 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses!');
        }
        
        try {
            DB::beginTransaction();
            
            // Kurangi stok barang
            $item = Item::findOrFail($loan->item_id);
            $item->reduceStock($loan->quantity);
            
            $loan->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Peminjaman disetujui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menolak peminjaman
     */
    public function reject(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        
        if ($loan->status != 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses!');
        }
        
        $loan->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'rejected_by' => Auth::id(),
            'rejection_reason' => $request->reason,
        ]);
        
        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    /**
     * Mengambil barang (setelah disetujui)
     */
    public function takeItem($id)
    {
        $loan = Loan::findOrFail($id);
        
        if ($loan->user_id != Auth::id() && !in_array(Auth::user()->role, ['admin', 'petugas'])) {
            return redirect()->back()->with('error', 'Unauthorized!');
        }
        
        if ($loan->status != 'approved') {
            return redirect()->back()->with('error', 'Peminjaman belum disetujui!');
        }
        
        $loan->update([
            'status' => 'borrowed',
            'taken_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Barang berhasil diambil.');
    }

    /**
     * Mengembalikan barang
     */
    public function returnLoan(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        
        if ($loan->status != 'borrowed') {
            return redirect()->back()->with('error', 'Barang belum diambil!');
        }
        
        try {
            DB::beginTransaction();
            
            $data = [
                'status' => 'returned',
                'returned_at' => now(),
                'payment_method' => $request->payment_method,
            ];
            
            if ($request->has('return_condition')) {
                $data['return_condition'] = $request->return_condition;
            }
            
            if ($request->has('damage_description')) {
                $data['damage_description'] = $request->damage_description;
            }
            
            $loan->update($data);
            
            // Kembalikan stok barang
            $item = Item::findOrFail($loan->item_id);
            $item->addStock($loan->quantity);
            
            DB::commit();
            
            return redirect()->back()->with('success', 'Barang berhasil dikembalikan.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus data peminjaman
     * Hanya dapat menghapus data dengan status 'returned' atau 'rejected'
     */
    public function destroy($id)
    {
        try {
            $loan = Loan::findOrFail($id);
            
            // Cek otorisasi - hanya admin dan petugas yang bisa menghapus
            if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak memiliki izin untuk menghapus data!'
                    ], 403);
                }
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus data!');
            }
            
            // Hanya izinkan hapus jika status returned atau rejected
            if (!in_array($loan->status, ['returned', 'rejected'])) {
                $message = 'Hanya peminjaman dengan status "Dikembalikan" atau "Ditolak" yang dapat dihapus!';
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 400);
                }
                return redirect()->back()->with('error', $message);
            }
            
            // Hapus data fine terkait jika ada
            if ($loan->fines && $loan->fines->count() > 0) {
                foreach ($loan->fines as $fine) {
                    $fine->delete();
                }
            }
            
            // Hapus data loan
            $loan->delete();
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data peminjaman berhasil dihapus!'
                ]);
            }
            
            return redirect()->back()->with('success', 'Data peminjaman berhasil dihapus!');
            
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Gagal menghapus data peminjaman: ' . $e->getMessage());
        }
    }

    /**
     * Cetak struk transaksi
     */
    public function printReceipt($id)
    {
        $loan = Loan::with(['user', 'item', 'fines'])->findOrFail($id);
        
        // Cek otorisasi
        if (!in_array(Auth::user()->role, ['admin', 'petugas']) && Auth::id() != $loan->user_id) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('receipt', compact('loan'));
    }

    /**
     * Menampilkan peminjaman user yang sedang login
     */
    public function userLoans()
    {
        $loans = Loan::with(['item', 'fines'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('my-loans', compact('loans'));
    }
}