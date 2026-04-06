<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Search parameter
        $search = $request->get('search');
        
        // Hitung total items
        $totalItems = Item::count();
        
        // Hitung items yang tersedia (stock > 0)
        $availableItems = Item::where('stock', '>', 0)->count();
        
        // Hitung total users
        $totalUsers = User::count();
        
        // Hitung peminjaman aktif
        $activeLoans = Loan::where('status', 'dipinjam')->count();
        
        // Hitung barang yang sedang dipinjam
        $borrowItems = Loan::where('status', 'dipinjam')->count();
        
        // Query items dengan search
        $itemsQuery = Item::select('id', 'name', 'description', 'kondisi', 'stock', 'foto');
        
        if ($search) {
            $itemsQuery->where('name', 'like', "%{$search}%");
        }
        
        $items = $itemsQuery->orderBy('created_at', 'desc')->paginate(10);
        
        // Data untuk chart 7 hari terakhir
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $last7Days->push([
                'date' => $date,
                'label' => $date->format('d M'),
                'full_date' => $date->format('Y-m-d')
            ]);
        }
        
        // Data peminjaman per hari (7 hari terakhir)
        $borrowStats = Loan::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        
        // Data pengembalian per hari (7 hari terakhir)
        $returnStats = Loan::select(
                DB::raw('DATE(returned_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('status', 'returned')
            ->where('returned_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        
        // Format data untuk chart
        $borrowData = [];
        $returnData = [];
        $labels = [];
        
        foreach ($last7Days as $day) {
            $labels[] = $day['label'];
            $borrowData[] = $borrowStats->get($day['full_date'])->total ?? 0;
            $returnData[] = $returnStats->get($day['full_date'])->total ?? 0;
        }
        
        // Data untuk chart kondisi items
        $itemStats = Item::select('kondisi', DB::raw('COUNT(*) as total'))
                         ->groupBy('kondisi')
                         ->get();
        
        // Jika tidak ada data, buat collection kosong
        if ($itemStats->isEmpty()) {
            $itemStats = collect([
                (object)['kondisi' => 'baik', 'total' => 0],
                (object)['kondisi' => 'rusak', 'total' => 0],
                (object)['kondisi' => 'hilang', 'total' => 0],
            ]);
        }
        
        return view('dashboard', compact(
            'totalItems',
            'availableItems',
            'totalUsers',
            'activeLoans',
            'borrowItems',
            'items',
            'itemStats',
            'borrowData',
            'returnData',
            'labels',
            'search'
        ));
    }
    
    public function dashboardData()
    {
        // Data untuk 7 hari terakhir
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $last7Days->push([
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('d M')
            ]);
        }
        
        // Data peminjaman per hari (7 hari terakhir)
        $borrowStats = Loan::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        
        // Data pengembalian per hari (7 hari terakhir)
        $returnStats = Loan::select(
                DB::raw('DATE(returned_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('status', 'returned')
            ->where('returned_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        
        // Format data untuk chart
        $borrowData = [];
        $returnData = [];
        $labels = [];
        
        foreach ($last7Days as $day) {
            $labels[] = $day['label'];
            $borrowData[] = $borrowStats->get($day['date'])->total ?? 0;
            $returnData[] = $returnStats->get($day['date'])->total ?? 0;
        }
        
        $data = [
            'totalItems' => Item::count(),
            'availableItems' => Item::where('stock', '>', 0)->count(),
            'totalUsers' => User::count(),
            'activeLoans' => Loan::where('status', 'dipinjam')->count(),
            'borrowItems' => Loan::where('status', 'dipinjam')->count(),
            'itemsByCondition' => Item::select('kondisi', DB::raw('COUNT(*) as total'))
                                      ->groupBy('kondisi')
                                      ->get(),
            'borrowStats' => $borrowStats,
            'returnStats' => $returnStats,
            'borrowData' => $borrowData,
            'returnData' => $returnData,
            'labels' => $labels
        ];
        
        return response()->json($data);
    }
    
    public function allItems()
    {
        $items = Item::paginate(12);
        return view('items.all', compact('items'));
    }
}