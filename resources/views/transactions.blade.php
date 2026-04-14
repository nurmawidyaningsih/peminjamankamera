@extends('layouts.app')

@section('title', 'Transaksi Pengembalian - Lentora')

@section('content')
<style>
    .fine-amount {
        color: #f97316;
        font-weight: bold;
        font-size: 1rem;
    }
    
    .total-fine {
        color: #ef4444;
        font-weight: bold;
        font-size: 1.1rem;
    }
    
    .status-paid {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        display: inline-block;
    }
    
    .status-pending {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        display: inline-block;
    }
    
    .status-waived {
        background: rgba(107, 114, 128, 0.2);
        color: #9ca3af;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        display: inline-block;
    }
    
    .btn-print {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        font-size: 0.75rem;
    }
    
    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .btn-pay-fine {
        background: linear-gradient(90deg, #f97316 0%, #ea580c 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
        font-size: 0.7rem;
    }
    
    .btn-pay-fine:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 10px rgba(249, 115, 22, 0.3);
        color: white;
        text-decoration: none;
    }
    
    .header-gradient {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    }
    
    .content-card {
        background: rgba(26, 26, 46, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(185, 166, 255, 0.15);
        border-radius: 1rem;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
    }
    
    .transaction-table th {
        color: #ffffff;
        font-weight: 600;
        padding: 1rem;
        background: rgba(184, 152, 233, 0.19);
    }
    
    .transaction-table td {
        padding: 0.75rem 1rem;
        color: #e0e0e0;
        border-bottom: 1px solid rgba(185, 166, 255, 0.1);
    }
    
    .transaction-table tr:hover {
        background: rgba(185, 166, 255, 0.05);
    }
    
    .price-text {
        color: #4ade80;
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .transaction-table th,
        .transaction-table td {
            padding: 0.5rem;
            font-size: 0.75rem;
        }
        
        .btn-print {
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
        }
    }
</style>

<div class="rounded-lg">
    <!-- Header -->
    <div class="header-gradient flex flex-col items-start justify-start px-4 py-4 mb-4">
        <div class="relative z-10">
            <p class="text-sm text-white">Pages / Transaksi</p>
            <p class="text-xl font-bold text-white">Riwayat Pengembalian</p>
        </div>
    </div>
    
    <!-- Tabel Transaksi -->
    <div class="flex flex-col justify-around gap-4 mx-4 lg:mx-10 -mt-36 mb-4 p-4 lg:p-8 rounded-xl content-card">
        <div class="flex flex-col gap-2 justify-start items-start p-4 lg:p-0">
            <h1 class="text-xl lg:text-2xl font-bold text-white">Riwayat Pengembalian</h1>
            <p class="text-sm text-white">Daftar semua transaksi pengembalian barang</p>
        </div>
        
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left transaction-table">
                <thead>
                    <tr class="border-b text-white">
                        <th class="p-3">No.</th>
                        <th class="p-3">Kode Transaksi</th>
                        <th class="p-3">Barang</th>
                        <th class="p-3">Harga/Hari</th>
                        <th class="p-3">Peminjam</th>
                        <th class="p-3 hidden sm:table-cell">Tgl Pinjam</th>
                        <th class="p-3 hidden sm:table-cell">Tgl Kembali (Aktual)</th>
                        <th class="p-3">Lama Sewa</th>
                        <th class="p-3">Kondisi</th>
                        <th class="p-3">Total Denda</th>
                        <th class="p-3 hidden md:table-cell">Status Denda</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                    @php
                        // Hitung lama peminjaman
                        $borrowDate = \Carbon\Carbon::parse($loan->borrow_date);
                        
                        if($loan->returned_at) {
                            $actualReturnDate = \Carbon\Carbon::parse($loan->returned_at);
                            $daysRaw = $borrowDate->diffInDays($actualReturnDate);
                            $days = round($daysRaw);
                            $displayReturnDate = $actualReturnDate->format('d/m/Y H:i');
                        } else {
                            $actualReturnDate = \Carbon\Carbon::parse($loan->return_date);
                            $daysRaw = $borrowDate->diffInDays($actualReturnDate);
                            $days = round($daysRaw);
                            $displayReturnDate = $actualReturnDate->format('d/m/Y') . ' (Jatuh Tempo)';
                        }
                        
                        $days = (int) $days;
                        
                        // 0 hari dianggap 1 hari
                        if($days < 1) {
                            $days = 1;
                        }
                        
                        $harga_per_hari = intval($loan->item->harga_sewa_perhari ?? 0);
                        $total_sewa = $harga_per_hari * $days;
                        
                        // Hitung total denda dari fines
                        $totalFineFromFines = $loan->fines->sum('amount');
                        $pendingFines = $loan->fines->where('status', 'pending');
                        $hasPending = $pendingFines->count() > 0;
                        $hasPaid = $loan->fines->where('status', 'paid')->count() > 0;
                        $hasWaived = $loan->fines->where('status', 'waived')->count() > 0;
                        
                        // DENDA KONDISI BARANG
                        // Kerusakan: dikalikan lama sewa (Rp 50.000 x hari)
                        // Hilang: TETAP (tidak dikalikan) Rp 100.000.000
                        $conditionFineAmount = 0;
                        $conditionFineType = null;
                        $hasConditionFineInFines = false;
                        
                        // Cek apakah sudah ada denda untuk kondisi ini di tabel fines
                        foreach($loan->fines as $fine) {
                            if($fine->fine_type == 'damage') {
                                $hasConditionFineInFines = true;
                            }
                            if($fine->fine_type == 'lost') {
                                $hasConditionFineInFines = true;
                            }
                        }
                        
                        if(($loan->return_condition == 'damaged' || $loan->return_condition == 'rusak') && !$hasConditionFineInFines) {
                            $conditionFineAmount = 50000 * $days; // Rp 50.000 x hari (DIKALIKAN)
                            $conditionFineType = 'damage';
                        } elseif(($loan->return_condition == 'lost') && !$hasConditionFineInFines) {
                            $conditionFineAmount = 100000000; // Rp 100.000.000 (TETAP, TIDAK DIKALIKAN)
                            $conditionFineType = 'lost';
                        }
                        
                        // TOTAL DENDA AKHIR
                        $totalFine = $totalFineFromFines + $conditionFineAmount;
                        
                        // Format display
                        $displayFineAmount = 'Rp ' . number_format($totalFine, 0, ',', '.');
                        $fineDetail = '';
                        
                        // Rincian dari fines
                        foreach($loan->fines as $fine) {
                            if($fine->fine_type == 'late') {
                                $fineDetail .= '📅 Keterlambatan: Rp ' . number_format($fine->amount, 0, ',', '.') . '<br>';
                            } elseif($fine->fine_type == 'damage') {
                                $fineDetail .= '🔧 Kerusakan: Rp ' . number_format($fine->amount, 0, ',', '.') . '<br>';
                            } elseif($fine->fine_type == 'lost') {
                                $fineDetail .= '❌ Kehilangan: Rp ' . number_format($fine->amount, 0, ',', '.') . '<br>';
                            }
                        }
                        
                        // Rincian denda kondisi (jika ada dan belum di fines)
                        if($conditionFineAmount > 0) {
                            if($conditionFineType == 'damage') {
                                $fineDetail .= '🔧 Denda Kerusakan (' . $days . ' hari x Rp 50.000): Rp ' . number_format($conditionFineAmount, 0, ',', '.') . '<br>';
                            } elseif($conditionFineType == 'lost') {
                                $fineDetail .= '❌ Denda Kehilangan: Rp ' . number_format($conditionFineAmount, 0, ',', '.') . '<br>';
                            }
                        }
                        
                        // Kondisi teks (tanpa background/badge)
                        $conditionText = '';
                        if($loan->return_condition == 'good' || $loan->return_condition == 'baik') {
                            $conditionText = '✓ Baik - Tidak ada kerusakan (Denda Rp 0)';
                        } elseif($loan->return_condition == 'damaged' || $loan->return_condition == 'rusak') {
                            $conditionText = '⚠ Rusak - Mengalami kerusakan (Denda Rp 50.000/hari x ' . $days . ' hari = Rp ' . number_format(50000 * $days, 0, ',', '.') . ')';
                        } elseif($loan->return_condition == 'lost') {
                            $conditionText = '✗ Hilang - Barang tidak ditemukan (Denda Rp 100.000.000)';
                        } else {
                            $conditionText = '-';
                        }
                    @endphp
                    <tr class="border-b border-[rgba(185,166,255,0.1)] hover:bg-[rgba(185,166,255,0.05)] transition-colors">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3 font-mono text-xs">
                            #{{ str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="p-3 font-medium text-white">{{ $loan->item->name ?? 'Barang dihapus' }}</td>
                        <td class="p-3 price-text">
                            Rp {{ number_format($harga_per_hari, 0, ',', '.') }}
                        </td>
                        <td class="p-3">{{ $loan->user->name ?? 'User dihapus' }}</td>
                        <td class="p-3 hidden sm:table-cell">
                            {{ \Carbon\Carbon::parse($loan->borrow_date)->format('d/m/Y') }}
                        </td>
                        <td class="p-3 hidden sm:table-cell">
                            {{ $displayReturnDate }}
                        </td>
                        <td class="p-3">
                            <div class="text-white font-semibold">{{ $days }} hari</div>
                            <div class="text-xs text-green-400">
                                Total: Rp {{ number_format($total_sewa, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="p-3">
                            {{ $conditionText }}
                        </td>
                        <td class="p-3">
                            @if($totalFine > 0)
                                <div>
                                    <span class="total-fine">{{ $displayFineAmount }}</span>
                                    <div class="text-xs text-gray-400 mt-1">
                                        {!! $fineDetail !!}
                                    </div>
                                </div>
                            @else
                                <div>
                                    <span class="text-green-400">✓ Tidak ada denda</span>
                                    <div class="text-xs text-gray-400">{{ $displayFineAmount }}</div>
                                </div>
                            @endif
                        </td>
                        <td class="p-3 hidden md:table-cell">
                            @if($hasPending || $conditionFineAmount > 0)
                                <span class="status-pending">⏳ Menunggu Pembayaran</span>
                            @elseif($hasPaid)
                                <span class="status-paid">✓ Lunas</span>
                            @elseif($hasWaived)
                                <span class="status-waived">⊘ Dihapus</span>
                            @else
                                <span class="text-green-400">✓ Selesai</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('transactions.receipt', $loan->id) }}" class="btn-print inline-block text-center">
                                    🖨 Cetak Struk
                                </a>
                                @foreach($pendingFines as $fine)
                                    @if(auth()->user()->role == 'admin' || auth()->user()->id == $loan->user_id)
                                    <form action="{{ route('fines.pay', $fine->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-pay-fine w-full text-center" 
                                                onclick="return confirm('Bayar denda Rp {{ number_format($fine->amount, 0, ',', '.') }}?')">
                                            💰 Bayar Denda
                                        </button>
                                    </form>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="w-16 h-16 text-[#6b6b8b] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-lg text-[#e0e0e0]">Belum ada transaksi pengembalian</p>
                                <p class="text-sm text-[#9ca3af] mt-1">Transaksi akan muncul setelah barang dikembalikan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($loans->count() > 0)
        <div class="mt-4 text-right pt-4 border-t border-[rgba(185,166,255,0.2)]">
            <p class="text-sm text-white">Total transaksi: <span class="text-white font-semibold">{{ $loans->total() }}</span></p>
        </div>
        @endif
        
        <div class="mt-4">
            {{ $loans->links() }}
        </div>
    </div>
</div>

@if (session('success'))
<div id="alert-success" class="fixed top-4 right-4 z-50 flex items-center p-3 rounded-lg bg-[#1e1e2f] border border-green-500/30 shadow-lg">
    <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 0 0 2v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <span class="text-green-400 text-sm">{{ session('success') }}</span>
</div>
@endif

@if (session('error'))
<div id="alert-error" class="fixed top-4 right-4 z-50 flex items-center p-3 rounded-lg bg-[#1e1e2f] border border-red-500/30 shadow-lg">
    <svg class="w-4 h-4 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 0 0 2v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <span class="text-red-400 text-sm">{{ session('error') }}</span>
</div>
@endif

<script>
    setTimeout(function() {
        const success = document.getElementById('alert-success');
        const error = document.getElementById('alert-error');
        if (success) success.style.display = 'none';
        if (error) error.style.display = 'none';
    }, 3000);
</script>
@endsection