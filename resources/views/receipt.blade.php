<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pengembalian - Lentora</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; background: #e0e0e0; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .receipt { width: 380px; background: white; padding: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.2); border-radius: 8px; }
        .receipt-header { text-align: center; border-bottom: 2px dashed #333; padding-bottom: 10px; margin-bottom: 15px; }
        .receipt-header h1 { font-size: 20px; letter-spacing: 2px; }
        .receipt-header p { font-size: 12px; color: #666; }
        .receipt-body { margin-bottom: 15px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12px; }
        .info-label { font-weight: bold; }
        .divider { border-top: 1px dashed #ccc; margin: 10px 0; }
        .total-row { display: flex; justify-content: space-between; margin-top: 10px; padding-top: 10px; border-top: 1px solid #333; font-weight: bold; font-size: 14px; }
        .fine-row { color: #f97316; font-weight: bold; }
        .rental-cost { background: #f0fdf4; padding: 8px; margin: 10px 0; border-radius: 5px; }
        .receipt-footer { text-align: center; border-top: 2px dashed #333; padding-top: 10px; margin-top: 15px; font-size: 10px; color: #666; }
        .signature { margin-top: 20px; display: flex; justify-content: space-between; font-size: 10px; }
        .btn-print { background: #4ade80; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 14px; margin-top: 20px; width: 100%; }
        .btn-print:hover { background: #22c55e; }
        .status-badge { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: bold; }
        .status-good { background: #dcfce7; color: #166534; }
        .status-damaged { background: #fed7aa; color: #9a3412; }
        .status-lost { background: #fee2e2; color: #991b1b; }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-unpaid { background: #fee2e2; color: #991b1b; }
        .text-green { color: #16a34a; }
        .text-orange { color: #ea580c; }
        .text-red { color: #dc2626; }
        @media print { body { background: white; padding: 0; } .btn-print { display: none; } .receipt { box-shadow: none; padding: 0; } }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>LENTORA</h1>
            <p>Sistem Peminjaman Barang</p>
            <p>Jl. Merdeka No. 123, Jakarta</p>
            <p>Telp: (021) 1234567</p>
        </div>
        
        <div class="receipt-body">
            @php
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
                $harga_per_hari = intval($loan->item->harga_sewa_perhari ?? 0);
                $total_sewa = $harga_per_hari * $days;
                
                $dueDate = \Carbon\Carbon::parse($loan->return_date);
                $lateDays = 0;
                if($loan->returned_at) {
                    $returnDateCheck = \Carbon\Carbon::parse($loan->returned_at);
                    if($returnDateCheck->gt($dueDate)) {
                        $lateDays = $dueDate->diffInDays($returnDateCheck);
                    }
                }
                
                $totalDenda = $loan->fines->sum('amount');
                $totalBayar = $total_sewa + $totalDenda;
            @endphp
            
            <div class="info-row">
                <span class="info-label">Kode Transaksi:</span>
                <span>{{ $loan->transaction_code ?? '#'.str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Kembali:</span>
                <span>{{ $displayReturnDate }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Petugas:</span>
                <span>{{ $loan->returnedBy->name ?? auth()->user()->name ?? '-' }}</span>
            </div>
            
            <div class="divider"></div>
            
            <div class="info-row">
                <span class="info-label">Nama Peminjam:</span>
                <span>{{ $loan->user->name ?? 'User dihapus' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Nama Barang:</span>
                <span>{{ $loan->item->name ?? 'Barang dihapus' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Harga Sewa/Hari:</span>
                <span class="text-green font-weight-bold">Rp {{ number_format($harga_per_hari, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jumlah:</span>
                <span>{{ $loan->amount }} unit</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Pinjam:</span>
                <span>{{ \Carbon\Carbon::parse($loan->borrow_date)->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jatuh Tempo:</span>
                <span>{{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') }}</span>
            </div>
            
            <div class="divider"></div>
            
            <div class="rental-cost">
                <div class="info-row">
                    <span class="info-label">📅 LAMA SEWA:</span>
                    <span>{{ $days }} hari</span>
                </div>
                <div class="info-row">
                    <span>Biaya Sewa ({{ $days }} x Rp {{ number_format($harga_per_hari, 0, ',', '.') }})</span>
                    <span>Rp {{ number_format($total_sewa, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div class="info-row">
                <span class="info-label">Kondisi Barang:</span>
                <span>
                    @if($loan->return_condition == 'good' || $loan->return_condition == 'baik')
                        <span class="status-badge status-good">✓ Baik</span>
                    @elseif($loan->return_condition == 'damaged' || $loan->return_condition == 'rusak')
                        <span class="status-badge status-damaged">⚠ Rusak</span>
                    @elseif($loan->return_condition == 'lost')
                        <span class="status-badge status-lost">✗ Hilang</span>
                    @else
                        <span>-</span>
                    @endif
                </span>
            </div>
            
            @if($loan->damage_description)
            <div class="info-row">
                <span class="info-label">Keterangan:</span>
                <span>{{ $loan->damage_description }}</span>
            </div>
            @endif
            
            <!-- DETAIL DENDA DENGAN NOMINAL -->
            @if($totalDenda > 0)
            <div class="divider"></div>
            <div class="fine-row">
                <div class="info-row">
                    <span>⚠️ DETAIL DENDA:</span>
                    <span></span>
                </div>
            </div>
            
            @foreach($loan->fines as $fine)
            <div class="info-row">
                <span class="info-label">
                    @if($fine->fine_type == 'late')
                        📅 Denda Keterlambatan
                    @elseif($fine->fine_type == 'damage')
                        🔧 Denda Kerusakan
                    @elseif($fine->fine_type == 'lost')
                        ❌ Denda Kehilangan
                    @else
                        Denda {{ $fine->fine_type }}
                    @endif
                </span>
                <span class="text-red">Rp {{ number_format($fine->amount, 0, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span>
                    @if($fine->status == 'paid')
                        <span class="status-badge status-paid">✓ LUNAS</span>
                    @elseif($fine->status == 'pending')
                        <span class="status-badge status-unpaid">⏳ BELUM DIBAYAR</span>
                    @else
                        <span class="status-badge">⊘ DIHAPUS</span>
                    @endif
                </span>
            </div>
            @endforeach
            @endif
            
            <div class="divider"></div>
            
            <div class="total-row">
                <span>TOTAL BIAYA SEWA</span>
                <span>Rp {{ number_format($total_sewa, 0, ',', '.') }}</span>
            </div>
            
            @if($totalDenda > 0)
            <div class="total-row fine-row">
                <span>TOTAL DENDA</span>
                <span class="text-red">Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
            </div>
            @else
            <div class="total-row">
                <span>TOTAL DENDA</span>
                <span class="text-green">Rp 0</span>
            </div>
            @endif
            
            <div class="total-row" style="border-top: 2px solid #333; margin-top: 5px; padding-top: 10px;">
                <span>TOTAL YANG HARUS DIBAYAR</span>
                <span style="color: #dc2626; font-size: 16px;">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
            </div>
            
            @if($lateDays > 0)
            <div class="info-row" style="margin-top: 10px;">
                <span class="info-label text-orange">Catatan:</span>
                <span class="text-orange">Terlambat {{ $lateDays }} hari</span>
            </div>
            @endif
        </div>
        
        <div class="receipt-footer">
            <p>Terima kasih telah menggunakan jasa kami!</p>
            <p>Barang yang dikembalikan dalam kondisi 
                @if($loan->return_condition == 'good' || $loan->return_condition == 'baik') baik
                @elseif($loan->return_condition == 'damaged' || $loan->return_condition == 'rusak') rusak
                @elseif($loan->return_condition == 'lost') hilang
                @endif
            </p>
            <p>*** Simpan struk ini sebagai bukti pengembalian ***</p>
        </div>
        
        <div class="signature">
            <div>
                <p>Peminjam,</p>
                <p style="margin-top: 30px;">_________________</p>
                <p>{{ $loan->user->name ?? '-' }}</p>
            </div>
            <div>
                <p>Petugas,</p>
                <p style="margin-top: 30px;">_________________</p>
                <p>{{ $loan->returnedBy->name ?? auth()->user()->name ?? '-' }}</p>
            </div>
        </div>
        
        <button class="btn-print" onclick="window.print()">🖨 Cetak Struk</button>
    </div>
</body>
</html>