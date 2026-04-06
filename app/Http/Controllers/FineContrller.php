<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FineController extends Controller
{
    public function pay($id)
    {
        $fine = Fine::findOrFail($id);
        
        // Cek apakah user berhak membayar denda ini
        if ($fine->loan->user_id != Auth::id() && !in_array(Auth::user()->role, ['admin', 'petugas'])) {
            return redirect()->back()->with('error', 'Anda tidak berhak membayar denda ini!');
        }
        
        if ($fine->status != 'pending') {
            return redirect()->back()->with('error', 'Denda sudah dibayar atau dihapus!');
        }
        
        $fine->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Denda sebesar Rp ' . number_format($fine->amount, 0, ',', '.') . ' berhasil dibayar!');
    }
    
    public function waive($id)
    {
        // Hanya admin yang bisa menghapus denda
        if (Auth::user()->role != 'admin') {
            return redirect()->back()->with('error', 'Unauthorized!');
        }
        
        $fine = Fine::findOrFail($id);
        
        $fine->update([
            'status' => 'waived',
        ]);
        
        return redirect()->back()->with('success', 'Denda berhasil dihapus!');
    }
}