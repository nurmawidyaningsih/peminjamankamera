@extends('layouts.app')

@section('title', 'Peminjaman Barang - Lentora')

@section('content')
<style>
    /* Status badges */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }
    
    .status-badge.pending {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .status-badge.approved {
        background: rgba(59, 130, 246, 0.2);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    
    .status-badge.borrowed {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }
    
    .status-badge.returned {
        background: rgba(107, 114, 128, 0.2);
        color: #9ca3af;
        border: 1px solid rgba(107, 114, 128, 0.3);
    }
    
    .status-badge.rejected {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .table-header th {
        color: white !important;
    }
    
    .table-container tbody td {
        color: white !important;
    }
    
    .table-container tbody td:first-child,
    .table-container tbody td:nth-child(4) {
        color: white !important;
        font-weight: 500;
    }
    
    .search-icon {
        color: white !important;
    }
    
    #returnCondition option {
        color: #000000 !important;
        background-color: #ffffff !important;
    }
    
    .btn-approve {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.75rem;
    }
    
    .btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }
    
    .btn-reject {
        background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.75rem;
    }
    
    .btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
    }
    
    .btn-take {
        background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.75rem;
    }
    
    .btn-take:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
    }
    
    .btn-return {
        background: linear-gradient(90deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.75rem;
    }
    
    .btn-return:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
    }
    
    .btn-delete {
        background: linear-gradient(90deg, #6b7280 0%, #4b5563 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.75rem;
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
        background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
    }
    
    .item-photo {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 2px solid rgba(185, 166, 255, 0.2);
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .table-container table {
        min-width: 1000px;
    }
    
    .table-container th, 
    .table-container td {
        white-space: nowrap;
        padding: 0.75rem 1rem;
    }
    
    .header-gradient {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        position: relative;
        overflow: hidden;
    }
    
    .content-card {
        background: rgba(26, 26, 46, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(185, 166, 255, 0.15);
        border-radius: 1rem;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
    }
    
    .form-container {
        background: rgba(26, 26, 46, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(185, 166, 255, 0.15);
        border-radius: 1rem;
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
    }
    
    .table-header {
        background: linear-gradient(90deg, rgba(185, 166, 255, 0.15) 0%, rgba(154, 135, 230, 0.1) 100%);
    }
    
    .search-input {
        background: rgba(26, 26, 46, 0.9);
        border: 1px solid rgba(185, 166, 255, 0.2);
        color: #e0e0e0;
        padding-left: 2.5rem;
        border-radius: 0.5rem;
    }
    
    .search-input:focus {
        border-color: #b9a6ff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(185, 166, 255, 0.2);
    }
    
    .approve-modal-content, .reject-modal-content, .return-modal-content, .delete-modal-content {
        background: #000000 !important;
        border: 1px solid rgba(185, 166, 255, 0.3);
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }
    
    .approve-modal-header, .reject-modal-header, .return-modal-header, .delete-modal-header {
        background: #000000;
        border-bottom: 1px solid rgba(185, 166, 255, 0.2);
    }
    
    .approve-modal-footer, .reject-modal-footer, .return-modal-footer, .delete-modal-footer {
        background: #000000;
        border-top: 1px solid rgba(185, 166, 255, 0.2);
    }
    
    .approve-modal-body, .reject-modal-body, .return-modal-body, .delete-modal-body {
        background: #000000;
    }
    
    #returnModal .bg-\[\#0f0f1a\] {
        background: #111111 !important;
    }
    
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(5px);
    }
    
    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(185, 166, 255, 0.2);
        border-top: 4px solid #b9a6ff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .loading-text {
        color: white;
        margin-top: 1rem;
        font-size: 0.9rem;
    }
    
    .notification-popup {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        animation: slideInRight 0.3s ease-out;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .notification-success {
        background: linear-gradient(135deg, #1e1e2f 0%, #2a2a40 100%);
        border-left: 4px solid #4ade80;
        border-radius: 0.75rem;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
    }
    
    #rejectReason,
    #rejectReason:focus,
    #rejectReason:active {
        color: #ffffff !important;
        background-color: #111111 !important;
        -webkit-text-fill-color: #ffffff !important;
    }
    
    #rejectReason::placeholder {
        color: #9ca3af !important;
        -webkit-text-fill-color: #9ca3af !important;
    }
    
    #damageDescription,
    #damageDescription:focus,
    #damageDescription:active {
        color: #ffffff !important;
        background-color: #111111 !important;
        -webkit-text-fill-color: #ffffff !important;
    }
    
    #damageDescription::placeholder {
        color: #9ca3af !important;
        -webkit-text-fill-color: #9ca3af !important;
    }
    
    #purpose,
    #purpose:focus,
    #purpose:active {
        color: #ffffff !important;
        background-color: #0f0f1a !important;
        -webkit-text-fill-color: #ffffff !important;
    }
    
    #purpose::placeholder {
        color: #9ca3af !important;
        -webkit-text-fill-color: #9ca3af !important;
    }
    
    .fine-amount {
        font-size: 1.25rem;
        font-weight: bold;
    }
    
    .payment-option {
        transition: all 0.3s ease;
    }
    
    .payment-option.selected {
        border-color: #10b981 !important;
        background: rgba(16, 185, 129, 0.1) !important;
    }
    
    .payment-option.selected-transfer {
        border-color: #3b82f6 !important;
        background: rgba(59, 130, 246, 0.1) !important;
    }
    
    .payment-radio {
        cursor: pointer;
    }
    
    .payment-radio:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }
    
    @media (max-width: 768px) {
        .table-container th, 
        .table-container td {
            padding: 0.5rem;
            font-size: 0.75rem;
        }
        
        .btn-approve, .btn-reject, .btn-take, .btn-return, .btn-delete {
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
        }
        
        .notification-popup {
            top: 10px;
            right: 10px;
            left: 10px;
        }
        
        .notification-popup .flex {
            min-width: auto;
        }
    }
</style>

<div class="rounded-lg">
    <div class="header-gradient flex flex-col items-start justify-start px-4 py-4 mb-4">
        <div class="relative z-10">
            <p class="text-md text-white">Pages / Peminjaman Barang</p>
            <p class="text-lg font-bold text-white">Peminjaman Barang</p>
        </div>
    </div>
    
    <div class="flex flex-col justify-around gap-4 mx-4 lg:mx-10 -mt-36 mb-4 p-4 lg:p-8 rounded-xl content-card">
        <div class="flex flex-col gap-2 justify-start items-start p-4 lg:p-0">
            <h1 class="text-xl lg:text-2xl font-bold text-white">📋 List Peminjaman</h1>
            <p class="text-sm text-white">Menampilkan semua permintaan peminjaman barang</p>
        </div>
        
        <div class="relative overflow-x-auto table-container">
            <div class="pb-4 bg-transparent p-4">
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 search-icon" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block pt-2 ps-10 text-sm rounded-lg w-full lg:w-80 search-input" placeholder="Cari berdasarkan nama barang atau peminjam...">
                </div>
            </div>
            
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase table-header">
                    <tr>
                        <th class="p-3">No</th>
                        <th class="px-3 py-3">Foto</th>
                        <th class="px-3 py-3">Nama Barang</th>
                        <th class="px-3 py-3">Jumlah</th>
                        <th class="px-3 py-3">Peminjam</th>
                        <th class="px-3 py-3">Tgl Pinjam</th>
                        <th class="px-3 py-3">Tgl Kembali</th>
                        <th class="px-3 py-3">Status</th>
                        <th class="px-3 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                    <tr class="border-b border-[rgba(185,166,255,0.1)] hover:bg-[rgba(185,166,255,0.05)]" id="loan-row-{{ $loan->id }}">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="px-3 py-4">
                            @if($loan->item && $loan->item->foto)
                                <img src="{{ asset('assets/img/' . $loan->item->foto) }}" alt="{{ $loan->item->name }}" class="item-photo">
                            @else
                                <div class="w-12 h-12 bg-[#2a2a40] rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#9ca3af]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-3 py-4 font-medium text-white">{{ $loan->item->name ?? 'Barang dihapus' }}</td>
                        <td class="px-3 py-4">{{ $loan->quantity }}</td>
                        <td class="px-3 py-4">{{ $loan->user->name ?? 'User dihapus' }}</td>
                        <td class="px-3 py-4">{{ \Carbon\Carbon::parse($loan->borrow_date)->format('d/m/Y') }}</td>
                        <td class="px-3 py-4">
                            @if($loan->return_date)
                                {{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') }}
                            @else
                                <span class="text-yellow-400">-</span>
                            @endif
                        </td>
                        <td class="px-3 py-4">
                            @php
                                $statusClass = '';
                                $statusText = '';
                                switch($loan->status) {
                                    case 'pending':
                                        $statusClass = 'pending';
                                        $statusText = '⏳ Menunggu Persetujuan';
                                        break;
                                    case 'approved':
                                        $statusClass = 'approved';
                                        $statusText = '✅ Disetujui';
                                        break;
                                    case 'borrowed':
                                        $statusClass = 'borrowed';
                                        $statusText = '📦 Dipinjam';
                                        break;
                                    case 'returned':
                                        $statusClass = 'returned';
                                        $statusText = '✓ Dikembalikan';
                                        break;
                                    case 'rejected':
                                        $statusClass = 'rejected';
                                        $statusText = '✗ Ditolak';
                                        break;
                                    default:
                                        $statusClass = 'pending';
                                        $statusText = '⏳ Menunggu';
                                }
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-3 py-4">
                            @php $status = $loan->status; @endphp
                            
                            @if($status == 'pending')
                                @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                                    <div class="action-buttons">
                                        <button onclick="openApproveModal({{ $loan->id }}, '{{ addslashes($loan->item->name) }}', '{{ addslashes($loan->user->name) }}', {{ $loan->quantity }})" 
                                                class="btn-approve">
                                            ✓ Setujui
                                        </button>
                                        <button onclick="openRejectModal({{ $loan->id }}, '{{ addslashes($loan->item->name) }}', '{{ addslashes($loan->user->name) }}')" 
                                                class="btn-reject">
                                            ✗ Tolak
                                        </button>
                                    </div>
                                @else
                                    <span class="text-yellow-400 text-sm">⏳ Menunggu Petugas</span>
                                @endif
                            
                            @elseif($status == 'approved')
                                @if(Auth::user()->id == $loan->user_id)
                                    <form action="{{ route('loans.take', $loan->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-take" onclick="return confirm('Ambil barang {{ addslashes($loan->item->name) }}?')">
                                            📦 Ambil Barang
                                        </button>
                                    </form>
                                @else
                                    <span class="text-blue-400 text-sm">Menunggu {{ $loan->user->name }} mengambil</span>
                                @endif
                            
                            @elseif($status == 'borrowed')
                                @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                                    <button onclick="openReturnModal({{ $loan->id }}, '{{ addslashes($loan->item->name) }}', {{ $loan->quantity }})" 
                                            class="btn-return">
                                        🔄 Kembalikan
                                    </button>
                                @else
                                    <span class="text-green-400 text-sm">Sedang Dipinjam</span>
                                @endif
                            
                            @elseif($status == 'returned')
                                @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                                    <button onclick="openDeleteModal({{ $loan->id }}, '{{ addslashes($loan->item->name) }}', '{{ addslashes($loan->user->name) }}')" 
                                            class="btn-delete">
                                        🗑️ Hapus
                                    </button>
                                @else
                                    <span class="text-gray-400 text-sm">✓ Selesai</span>
                                @endif
                            
                            @elseif($status == 'rejected')
                                @if(in_array(Auth::user()->role, ['admin', 'petugas']))
                                    <button onclick="openDeleteModal({{ $loan->id }}, '{{ addslashes($loan->item->name) }}', '{{ addslashes($loan->user->name) }}')" 
                                            class="btn-delete">
                                        🗑️ Hapus
                                    </button>
                                @else
                                    <span class="text-red-400 text-sm">✗ Ditolak</span>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="w-16 h-16 text-[#6b6b8b] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-lg text-white">Belum ada data peminjaman</p>
                                <p class="text-sm text-white mt-1">Silakan ajukan peminjaman melalui form di bawah</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="flex flex-col justify-around gap-4 mx-4 lg:mx-10 mb-4 p-4 lg:p-8 rounded-xl form-container">
        <div class="flex flex-col gap-6 justify-start items-start p-4 lg:p-0">
            <h1 class="text-xl lg:text-2xl font-bold text-white">➕ Tambah Barang Peminjaman</h1>
            <p class="text-sm text-white">Isi form di bawah untuk mengajukan peminjaman barang. Peminjaman akan diproses oleh petugas.</p>
        </div>
        <div class="flex justify-start p-2">
            <form id="borrowForm" action="{{ route('loans.borrow') }}" method="POST" class="w-full">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="item_id" class="block text-white mb-2">Pilih Barang</label>
                        <select id="item_id" name="item_id" class="form-control w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($items as $availableItem)
                                <option value="{{ $availableItem->id }}" data-stock="{{ $availableItem->stock }}" data-name="{{ $availableItem->name }}">
                                    {{ $availableItem->name }} (Stok: {{ $availableItem->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantity" class="block text-white mb-2">Jumlah Barang</label>
                        <input type="number" id="quantity" name="quantity" class="form-control w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" placeholder="Jumlah yang ingin dipinjam" required min="1" />
                    </div>
                    
                    <div class="form-group">
                        <label for="user" class="block text-white mb-2">Peminjam</label>
                        <input type="text" id="user" name="user" class="form-control w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" value="{{ Auth::user()->name }}" readonly />
                    </div>
                    
                    <div class="form-group">
                        <label for="borrow_date" class="block text-white mb-2">Tanggal Peminjaman</label>
                        <input type="date" id="borrow_date" name="borrow_date" class="form-control w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" value="{{ now()->format('Y-m-d') }}" required />
                    </div>
                    
                    <div class="form-group">
                        <label for="return_date" class="block text-white mb-2">Tanggal Kembali</label>
                        <input type="date" id="return_date" name="return_date" class="form-control w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" value="{{ now()->addDays(7)->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}" required />
                    </div>
                    
                    <div class="form-group md:col-span-2">
                        <label for="purpose" class="block text-white mb-2">Keterangan / Tujuan</label>
                        <textarea id="purpose" name="purpose" rows="3" class="form-control w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)]" style="color: #ffffff !important; background-color: #0f0f1a !important;" placeholder="Peminjaman untuk apa? (contoh: untuk kegiatan rapat)" required></textarea>
                    </div>
                </div>
                
                <div id="stockWarning" class="mt-4" style="display: none;"></div>
                
                <div class="info-note bg-yellow-500/10 p-3 rounded-lg mt-4">
                    <svg class="w-5 h-5 inline text-[#b9a6ff]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm text-white">📋 Peminjaman akan diproses oleh petugas. Status akan berubah menjadi <strong>"Disetujui"</strong> setelah diverifikasi. Kemudian Anda dapat mengambil barang.</span>
                </div>
                
                <div class="flex justify-end mt-6">
                    <button type="submit" id="submitBtn" class="bg-gradient-to-r from-[#b9a6ff] to-[#9a87e6] text-white font-semibold px-6 py-2 rounded-lg">
                        Ajukan Peminjaman
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div id="approveModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80">
    <div class="relative p-4 w-full max-w-md">
        <div class="approve-modal-content">
            <div class="approve-modal-header flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Konfirmasi Persetujuan
                </h3>
                <button onclick="closeApproveModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="approve-modal-body p-6 text-center">
                <svg class="mx-auto mb-4 text-green-500 w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-white mb-2" id="approveMessage"></p>
                <p class="text-sm text-yellow-400 mt-2 bg-yellow-500/10 p-2 rounded-lg" id="approveStockWarning"></p>
            </div>
            <div class="approve-modal-footer flex justify-center gap-3 p-4 border-t">
                <form id="approveForm" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg transition-all shadow-md hover:shadow-lg">
                        ✓ Ya, Setujui
                    </button>
                </form>
                <button onclick="closeApproveModal()" class="border border-gray-500 hover:border-gray-400 text-gray-400 hover:text-white px-5 py-2 rounded-lg transition-all">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div id="rejectModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80">
    <div class="relative p-4 w-full max-w-md">
        <div class="reject-modal-content">
            <div class="reject-modal-header flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Tolak Peminjaman
                </h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="reject-modal-body p-6">
                    <p class="text-white mb-4 text-center" id="rejectMessage"></p>
                    <label class="block text-white mb-2 font-medium">Alasan Penolakan</label>
                    <textarea name="reason" id="rejectReason" rows="3" style="color: #ffffff !important; background-color: #111111 !important; border: 1px solid rgba(185,166,255,0.2); width: 100%; padding: 0.625rem; border-radius: 0.5rem; -webkit-text-fill-color: #ffffff !important;" placeholder="Masukkan alasan penolakan..." required></textarea>
                </div>
                <div class="reject-modal-footer flex justify-center gap-3 p-4 border-t">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg transition-all shadow-md hover:shadow-lg">
                        ✗ Tolak
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="border border-gray-500 hover:border-gray-400 text-gray-400 hover:text-white px-5 py-2 rounded-lg transition-all">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80">
    <div class="relative p-4 w-full max-w-md">
        <div class="delete-modal-content">
            <div class="delete-modal-header flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Data Peminjaman
                </h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="delete-modal-body p-6 text-center">
                <svg class="mx-auto mb-4 text-red-500 w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-white mb-2" id="deleteMessage"></p>
                <p class="text-sm text-yellow-400 mt-2 bg-yellow-500/10 p-2 rounded-lg">⚠️ Tindakan ini tidak dapat dibatalkan. Data akan dihapus secara permanen.</p>
            </div>
            <div class="delete-modal-footer flex justify-center gap-3 p-4 border-t">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg transition-all shadow-md hover:shadow-lg">
                        🗑️ Ya, Hapus
                    </button>
                </form>
                <button onclick="closeDeleteModal()" class="border border-gray-500 hover:border-gray-400 text-gray-400 hover:text-white px-5 py-2 rounded-lg transition-all">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Return -->
<div id="returnModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80">
    <div class="relative p-4 w-full max-w-md">
        <div class="return-modal-content rounded-xl">
            <div class="return-modal-header flex justify-between items-center p-4 border-b border-[rgba(185,166,255,0.2)] sticky top-0 bg-black z-10 rounded-t-xl">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Pengembalian Barang
                </h3>
                <button onclick="closeReturnModal()" class="text-gray-400 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="returnForm" method="POST">
                @csrf
                <input type="hidden" name="payment_method" id="payment_method_selected" value="cash">
                
                <div class="return-modal-body p-6 space-y-4 overflow-y-auto" style="max-height: 60vh; min-height: 500px;">
                    <div class="bg-[#111111] rounded-lg p-4 text-center border border-[rgba(185,166,255,0.2)]">
                        <svg class="w-12 h-12 text-orange-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-white font-medium" id="returnMessage"></p>
                        <p class="text-gray-400 text-xs mt-1">Pastikan kondisi barang sesuai sebelum mengembalikan</p>
                    </div>
                    
                    <div id="estimatedFine" class="bg-gradient-to-r from-yellow-900/30 to-orange-900/30 border border-yellow-500/30 rounded-lg p-3 hidden">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-yellow-400 text-sm font-semibold">💰 Estimasi Denda</p>
                                <p class="text-white text-xl font-bold" id="estimatedFineAmount">Rp 0</p>
                                <p class="text-gray-400 text-xs">*Denda akan dihitung otomatis berdasarkan kondisi</p>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-white mb-2 font-medium">Kondisi Barang</label>
                        <select name="return_condition" id="returnCondition" class="w-full p-2.5 rounded-lg bg-white border border-gray-300" style="color: #000000;" required>
                            <option value="good" style="color: #000000; background-color: #ffffff;">✓ Baik - Tidak ada kerusakan (Denda Rp 0)</option>
                            <option value="damaged" style="color: #000000; background-color: #ffffff;">⚠ Rusak - Mengalami kerusakan (Denda Rp 50.000/hari)</option>
                            <option value="lost" style="color: #000000; background-color: #ffffff;">✗ Hilang - Barang tidak ditemukan (Denda Rp 100.000.000)</option>
                        </select>
                    </div>
                    
                    <div id="damageFields" style="display: none;">
                        <label class="block text-white mb-2 font-medium">Keterangan Kerusakan/Kehilangan</label>
                        <textarea name="damage_description" id="damageDescription" rows="3" style="color: #ffffff !important; background-color: #111111 !important; border: 1px solid rgba(185,166,255,0.2); width: 100%; padding: 0.625rem; border-radius: 0.5rem; -webkit-text-fill-color: #ffffff !important;" placeholder="Jelaskan secara detail kondisi kerusakan atau kehilangan barang..."></textarea>
                    </div>
                    
                    <div class="bg-gradient-to-r from-blue-900/30 to-purple-900/30 border border-blue-500/30 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <p class="text-white font-semibold">💳 METODE PEMBAYARAN</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div id="paymentOptionCash" class="payment-option p-3 rounded-lg bg-[#1a1a2e] border border-[rgba(185,166,255,0.2)] cursor-pointer transition-all hover:border-green-500" onclick="selectPaymentMethod('cash')">
                                <div class="flex items-center justify-center gap-2">
                                    <input type="radio" name="payment_method_radio" id="payment_cash" value="cash" class="w-4 h-4 text-green-500 payment-radio" checked>
                                    <label for="payment_cash" class="text-white text-sm cursor-pointer">💵 CASH (Tunai)</label>
                                </div>
                                <p class="text-gray-400 text-xs text-center mt-1">Bayar langsung secara tunai</p>
                            </div>
                            
                            <div id="paymentOptionTransfer" class="payment-option p-3 rounded-lg bg-[#1a1a2e] border border-[rgba(185,166,255,0.2)] cursor-pointer transition-all hover:border-blue-500" onclick="selectPaymentMethod('transfer')">
                                <div class="flex items-center justify-center gap-2">
                                    <input type="radio" name="payment_method_radio" id="payment_transfer" value="transfer" class="w-4 h-4 text-blue-500 payment-radio">
                                    <label for="payment_transfer" class="text-white text-sm cursor-pointer">🏦 TRANSFER BANK (TF)</label>
                                </div>
                                <p class="text-gray-400 text-xs text-center mt-1">Bayar via transfer bank</p>
                            </div>
                        </div>
                        
                        <div id="transferInfo" class="hidden mt-3 p-4 bg-white rounded-lg text-center">
                            <div class="flex justify-center mb-3">
                                <div class="bg-black p-3 rounded-lg">
                                    <svg width="120" height="120" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="120" height="120" fill="white"/>
                                        <rect x="10" y="10" width="22" height="22" fill="black"/>
                                        <rect x="12" y="12" width="18" height="18" fill="white"/>
                                        <rect x="14" y="14" width="14" height="14" fill="black"/>
                                        <rect x="88" y="10" width="22" height="22" fill="black"/>
                                        <rect x="90" y="12" width="18" height="18" fill="white"/>
                                        <rect x="92" y="14" width="14" height="14" fill="black"/>
                                        <rect x="10" y="88" width="22" height="22" fill="black"/>
                                        <rect x="12" y="90" width="18" height="18" fill="white"/>
                                        <rect x="14" y="92" width="14" height="14" fill="black"/>
                                        <rect x="38" y="10" width="5" height="5" fill="black"/>
                                        <rect x="48" y="10" width="5" height="5" fill="black"/>
                                        <rect x="58" y="10" width="5" height="5" fill="black"/>
                                        <rect x="68" y="10" width="5" height="5" fill="black"/>
                                        <rect x="78" y="10" width="5" height="5" fill="black"/>
                                        <rect x="38" y="20" width="5" height="5" fill="black"/>
                                        <rect x="58" y="20" width="5" height="5" fill="black"/>
                                        <rect x="78" y="20" width="5" height="5" fill="black"/>
                                        <rect x="10" y="38" width="5" height="5" fill="black"/>
                                        <rect x="25" y="38" width="5" height="5" fill="black"/>
                                        <rect x="38" y="38" width="5" height="5" fill="black"/>
                                        <rect x="52" y="38" width="5" height="5" fill="black"/>
                                        <rect x="68" y="38" width="5" height="5" fill="black"/>
                                        <rect x="82" y="38" width="5" height="5" fill="black"/>
                                        <rect x="95" y="38" width="5" height="5" fill="black"/>
                                        <rect x="105" y="38" width="5" height="5" fill="black"/>
                                        <rect x="10" y="52" width="5" height="5" fill="black"/>
                                        <rect x="25" y="52" width="5" height="5" fill="black"/>
                                        <rect x="48" y="52" width="5" height="5" fill="black"/>
                                        <rect x="62" y="52" width="5" height="5" fill="black"/>
                                        <rect x="82" y="52" width="5" height="5" fill="black"/>
                                        <rect x="95" y="52" width="5" height="5" fill="black"/>
                                        <rect x="105" y="52" width="5" height="5" fill="black"/>
                                        <rect x="10" y="68" width="5" height="5" fill="black"/>
                                        <rect x="30" y="68" width="5" height="5" fill="black"/>
                                        <rect x="48" y="68" width="5" height="5" fill="black"/>
                                        <rect x="68" y="68" width="5" height="5" fill="black"/>
                                        <rect x="85" y="68" width="5" height="5" fill="black"/>
                                        <rect x="105" y="68" width="5" height="5" fill="black"/>
                                        <rect x="38" y="82" width="5" height="5" fill="black"/>
                                        <rect x="52" y="82" width="5" height="5" fill="black"/>
                                        <rect x="68" y="82" width="5" height="5" fill="black"/>
                                        <rect x="82" y="82" width="5" height="5" fill="black"/>
                                        <rect x="105" y="82" width="5" height="5" fill="black"/>
                                        <rect x="38" y="95" width="5" height="5" fill="black"/>
                                        <rect x="58" y="95" width="5" height="5" fill="black"/>
                                        <rect x="78" y="95" width="5" height="5" fill="black"/>
                                        <rect x="95" y="95" width="5" height="5" fill="black"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-800 font-bold text-sm">QRIS / Scan to Pay</p>
                            <p class="text-gray-500 text-xs mt-1">Bayar via Transfer Bank</p>
                            <div class="mt-3 p-3 bg-gray-100 rounded-lg">
                                <p class="text-gray-600 text-xs">🏦 BCA / Mandiri / BRI</p>
                                <p class="text-gray-800 text-sm font-bold mt-1">1234-5678-9012-3456</p>
                                <p class="text-gray-500 text-xs">a.n. LENTORA OFFICIAL</p>
                            </div>
                            <button type="button" onclick="copyBankAccount()" class="mt-3 text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all flex items-center justify-center gap-2 w-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                📋 Salin No. Rekening
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-xl p-4 border border-gray-700 shadow-lg">
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-700">
                            <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-white font-semibold text-base">💰 Rincian Denda</p>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 px-2 rounded-lg bg-gray-800/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
                                        <span class="text-green-400 text-sm">✓</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium text-sm">Kondisi Baik</p>
                                        <p class="text-gray-400 text-xs">Tidak ada kerusakan</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-green-400 font-bold">Rp 0</p>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 px-2 rounded-lg bg-gray-800/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-orange-500/20 flex items-center justify-center">
                                        <span class="text-orange-400 text-sm">⚠️</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium text-sm">Kondisi Rusak</p>
                                        <p class="text-gray-400 text-xs">Mengalami kerusakan (per hari)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-orange-400 font-bold">Rp 50.000</p>
                                    <p class="text-gray-500 text-xs">/ hari</p>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center py-2 px-2 rounded-lg bg-gray-800/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-red-500/20 flex items-center justify-center">
                                        <span class="text-red-400 text-sm">❌</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium text-sm">Kondisi Hilang</p>
                                        <p class="text-gray-400 text-xs">Barang tidak ditemukan</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-red-400 font-bold">Rp 100.000.000</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3 pt-3 border-t border-gray-700">
                            <div class="flex justify-between items-center py-2 px-2 rounded-lg bg-gray-800/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-yellow-500/20 flex items-center justify-center">
                                        <span class="text-yellow-400 text-sm">📅</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium text-sm">Denda Keterlambatan</p>
                                        <p class="text-gray-400 text-xs">Per hari setelah jatuh tempo</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-yellow-400 font-bold">Rp 5.000</p>
                                    <p class="text-gray-500 text-xs">/ hari</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="return-modal-footer flex justify-end gap-3 p-4 border-t border-[rgba(185,166,255,0.2)] sticky bottom-0 bg-black z-10 rounded-b-xl">
                    <button type="button" onclick="closeReturnModal()" class="px-4 py-2 rounded-lg border border-gray-500 text-gray-400 hover:text-white hover:border-white transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold transition-all shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Proses Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<audio id="successSound" preload="auto">
    <source src="{{ asset('sound/sound1.wav') }}" type="audio/wav">
</audio>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<div id="alert-success" class="fixed top-4 right-4 z-50 flex items-center p-4 rounded-lg shadow-lg bg-green-500/20 border border-green-500/30">
    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 0 0 2v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <span class="text-green-400">{{ session('success') }}</span>
</div>
@endif

@if (session('error'))
<div id="alert-error" class="fixed top-4 right-4 z-50 flex items-center p-4 rounded-lg shadow-lg bg-red-500/20 border border-red-500/30">
    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 0 0 2v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <span class="text-red-400">{{ session('error') }}</span>
</div>
@endif

<script>
    let currentItemPrice = 0;
    let currentQuantity = 0;
    
    function playSuccessSound() {
        const audio = document.getElementById('successSound');
        if (audio) {
            audio.currentTime = 0;
            audio.play().catch(function(error) {
                console.log('Audio playback failed:', error);
            });
        }
    }
    
    function showNotification(message, type) {
        type = type || 'success';
        const existingNotif = document.querySelector('.notification-popup');
        if (existingNotif) existingNotif.remove();
        
        const colors = {
            success: { border: '#4ade80', icon: '✓', iconBg: '#4ade80' },
            error: { border: '#ef4444', icon: '✗', iconBg: '#ef4444' },
            info: { border: '#b9a6ff', icon: 'ℹ', iconBg: '#b9a6ff' }
        };
        
        const style = colors[type] || colors.success;
        
        const notification = document.createElement('div');
        notification.className = 'notification-popup';
        notification.innerHTML = '<div class="flex items-center p-4 rounded-lg shadow-xl notification-success" style="background: linear-gradient(135deg, #1e1e2f 0%, #2a2a40 100%); border-left-color: ' + style.border + '; min-width: 300px;"><div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center mr-3" style="background: ' + style.iconBg + '20;"><span class="text-lg font-bold" style="color: ' + style.iconBg + '">' + style.icon + '</span></div><div class="flex-1"><p class="text-white font-medium text-sm">' + message + '</p><p class="text-gray-400 text-xs mt-1">' + new Date().toLocaleTimeString() + '</p></div><button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-gray-400 hover:text-white"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button></div>';
        
        document.body.appendChild(notification);
        setTimeout(function() {
            if (notification && notification.parentElement) {
                notification.style.animation = 'slideInRight 0.3s ease-out reverse';
                setTimeout(function() { notification.remove(); }, 300);
            }
        }, 5000);
    }
    
    function showSweetAlert(title, message, type) {
        type = type || 'success';
        Swal.fire({
            title: title,
            text: message,
            icon: type,
            background: '#1e1e2f',
            color: '#fff',
            confirmButtonColor: '#b9a6ff',
            confirmButtonText: 'OK',
            timer: type === 'success' ? 3000 : undefined,
            backdrop: 'rgba(0,0,0,0.7)',
            customClass: {
                popup: 'rounded-xl border border-[rgba(185,166,255,0.2)]'
            }
        });
    }
    
    function showLoading() {
        const loadingDiv = document.createElement('div');
        loadingDiv.id = 'loadingOverlay';
        loadingDiv.className = 'loading-overlay';
        loadingDiv.innerHTML = '<div class="text-center"><div class="loading-spinner mx-auto"></div><p class="loading-text mt-3">Memproses...</p></div>';
        document.body.appendChild(loadingDiv);
    }
    
    function hideLoading() {
        const loading = document.getElementById('loadingOverlay');
        if (loading) loading.remove();
    }
    
    function openApproveModal(loanId, itemName, userName, amount) {
        document.getElementById('approveMessage').innerHTML = 'Setujui peminjaman <strong class="text-green-400">' + itemName + '</strong> oleh <strong class="text-blue-400">' + userName + '</strong>?';
        document.getElementById('approveStockWarning').innerHTML = '⚠️ Stok akan berkurang <strong>' + amount + '</strong> setelah disetujui.';
        document.getElementById('approveForm').action = '/loans/' + loanId + '/approve';
        document.getElementById('approveModal').classList.remove('hidden');
    }
    
    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
    }
    
    function openRejectModal(loanId, itemName, userName) {
        document.getElementById('rejectMessage').innerHTML = 'Tolak peminjaman <strong class="text-red-400">' + itemName + '</strong> oleh <strong>' + userName + '</strong>?';
        document.getElementById('rejectForm').action = '/loans/' + loanId + '/reject';
        document.getElementById('rejectModal').classList.remove('hidden');
        const textarea = document.getElementById('rejectReason');
        if (textarea) textarea.value = '';
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        const reason = document.getElementById('rejectReason');
        if (reason) reason.value = '';
    }
    
    function openDeleteModal(loanId, itemName, userName) {
        document.getElementById('deleteMessage').innerHTML = 'Hapus data peminjaman <strong class="text-red-400">' + itemName + '</strong> oleh <strong>' + userName + '</strong>?';
        document.getElementById('deleteForm').action = '/loans/' + loanId;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    document.getElementById('deleteForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            background: '#1e1e2f',
            color: '#fff',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                
                fetch(this.action, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    closeDeleteModal();
                    
                    if (data.success) {
                        playSuccessSound();
                        showNotification(data.message, 'success');
                        const rowId = this.action.split('/').pop();
                        const row = document.getElementById('loan-row-' + rowId);
                        if (row) row.remove();
                        
                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            background: '#1e1e2f',
                            color: '#fff',
                            confirmButtonColor: '#b9a6ff',
                            timer: 2000
                        }).then(() => {
                            if (document.querySelectorAll('tbody tr').length === 0) {
                                window.location.reload();
                            }
                        });
                    } else {
                        showNotification(data.message, 'error');
                        Swal.fire({
                            title: 'Gagal!',
                            text: data.message,
                            icon: 'error',
                            background: '#1e1e2f',
                            color: '#fff',
                            confirmButtonColor: '#b9a6ff'
                        });
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    showNotification('Terjadi kesalahan jaringan', 'error');
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menghubungi server.',
                        icon: 'error',
                        background: '#1e1e2f',
                        color: '#fff',
                        confirmButtonColor: '#b9a6ff'
                    });
                });
            }
        });
    });
    
    function calculateFineByCondition(condition) {
        switch(condition) {
            case 'good': return 0;
            case 'damaged': return 50000;
            case 'lost': return 100000000;
            default: return 0;
        }
    }
    
    function copyBankAccount() {
        const bankNumber = '1234-5678-9012-3456';
        navigator.clipboard.writeText(bankNumber).then(function() {
            showNotification('Nomor rekening berhasil disalin!', 'success');
            Swal.fire({
                title: 'Berhasil!',
                text: 'Nomor rekening telah disalin ke clipboard',
                icon: 'success',
                background: '#1e1e2f',
                color: '#fff',
                confirmButtonColor: '#b9a6ff',
                timer: 2000,
                showConfirmButton: false
            });
        });
    }
    
    function selectPaymentMethod(method) {
        const cashRadio = document.getElementById('payment_cash');
        const transferRadio = document.getElementById('payment_transfer');
        const paymentHidden = document.getElementById('payment_method_selected');
        const transferInfo = document.getElementById('transferInfo');
        const paymentOptionCash = document.getElementById('paymentOptionCash');
        const paymentOptionTransfer = document.getElementById('paymentOptionTransfer');
        
        if (method === 'cash') {
            if (cashRadio) {
                cashRadio.checked = true;
                cashRadio.dispatchEvent(new Event('change'));
            }
            if (transferRadio) transferRadio.checked = false;
            if (paymentHidden) paymentHidden.value = 'cash';
            if (transferInfo) transferInfo.classList.add('hidden');
            if (paymentOptionCash) {
                paymentOptionCash.style.borderColor = '#10b981';
                paymentOptionCash.style.background = 'rgba(16, 185, 129, 0.1)';
            }
            if (paymentOptionTransfer) {
                paymentOptionTransfer.style.borderColor = 'rgba(185,166,255,0.2)';
                paymentOptionTransfer.style.background = '#1a1a2e';
            }
        } else if (method === 'transfer') {
            if (transferRadio) {
                transferRadio.checked = true;
                transferRadio.dispatchEvent(new Event('change'));
            }
            if (cashRadio) cashRadio.checked = false;
            if (paymentHidden) paymentHidden.value = 'transfer';
            if (transferInfo) transferInfo.classList.remove('hidden');
            if (paymentOptionTransfer) {
                paymentOptionTransfer.style.borderColor = '#3b82f6';
                paymentOptionTransfer.style.background = 'rgba(59, 130, 246, 0.1)';
            }
            if (paymentOptionCash) {
                paymentOptionCash.style.borderColor = 'rgba(185,166,255,0.2)';
                paymentOptionCash.style.background = '#1a1a2e';
            }
        }
    }
    
    function openReturnModal(loanId, itemName, amount) {
        currentQuantity = amount;
        document.getElementById('returnMessage').innerHTML = 'Kembalikan barang <strong>' + itemName + '</strong> (' + amount + ' unit)?';
        document.getElementById('returnForm').action = '/loans/' + loanId + '/return';
        
        selectPaymentMethod('cash');
        
        document.getElementById('returnCondition').value = 'good';
        document.getElementById('damageFields').style.display = 'none';
        document.getElementById('damageDescription').value = '';
        document.getElementById('estimatedFine').classList.add('hidden');
        
        document.getElementById('returnModal').classList.remove('hidden');
    }
    
    function closeReturnModal() {
        document.getElementById('returnModal').classList.add('hidden');
        document.getElementById('returnCondition').value = 'good';
        document.getElementById('damageFields').style.display = 'none';
        document.getElementById('damageDescription').value = '';
        document.getElementById('estimatedFine').classList.add('hidden');
    }
    
    function validateStock() {
        var itemSelect = document.getElementById('item_id');
        var amountInput = document.getElementById('quantity');
        var submitBtn = document.getElementById('submitBtn');
        var stockWarning = document.getElementById('stockWarning');
        
        if (!itemSelect || !amountInput) return;
        
        var selectedOption = itemSelect.options[itemSelect.selectedIndex];
        var stock = selectedOption.getAttribute('data-stock');
        var itemName = selectedOption.getAttribute('data-name');
        var amount = parseInt(amountInput.value) || 0;
        
        stockWarning.style.display = 'none';
        stockWarning.innerHTML = '';
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';
        }
        
        if (!itemSelect.value) {
            stockWarning.innerHTML = '<div class="bg-yellow-500/20 border border-yellow-500/30 rounded-lg p-2 text-sm text-yellow-400">⚠️ Silakan pilih barang terlebih dahulu</div>';
            stockWarning.style.display = 'block';
            if (submitBtn) submitBtn.disabled = true;
            return false;
        }
        
        if (amount === 0) {
            stockWarning.innerHTML = '<div class="bg-yellow-500/20 border border-yellow-500/30 rounded-lg p-2 text-sm text-yellow-400">⚠️ Silakan masukkan jumlah barang</div>';
            stockWarning.style.display = 'block';
            if (submitBtn) submitBtn.disabled = true;
            return false;
        }
        
        if (stock && amount > parseInt(stock)) {
            stockWarning.innerHTML = '<div class="bg-red-500/20 border border-red-500/30 rounded-lg p-2 text-sm text-red-400">❌ Stok tidak mencukupi! Stok ' + itemName + ' tersedia: ' + stock + ' unit</div>';
            stockWarning.style.display = 'block';
            if (submitBtn) submitBtn.disabled = true;
            return false;
        } else if (stock && amount > 0) {
            stockWarning.innerHTML = '<div class="bg-green-500/20 border border-green-500/30 rounded-lg p-2 text-sm text-green-400">✓ Stok mencukupi (' + stock + ' unit tersedia)</div>';
            stockWarning.style.display = 'block';
            if (submitBtn) submitBtn.disabled = false;
            return true;
        }
        
        return true;
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        var returnCondition = document.getElementById('returnCondition');
        if (returnCondition) {
            returnCondition.addEventListener('change', function() {
                var damageFields = document.getElementById('damageFields');
                var estimatedFine = document.getElementById('estimatedFine');
                
                if (damageFields) {
                    damageFields.style.display = (this.value === 'damaged' || this.value === 'lost') ? 'block' : 'none';
                }
                
                if (estimatedFine) {
                    estimatedFine.classList.remove('hidden');
                    var fineAmount = calculateFineByCondition(this.value);
                    var formattedFine = 'Rp ' + fineAmount.toLocaleString('id-ID');
                    if (this.value === 'damaged') {
                        formattedFine = 'Rp 50.000 / hari';
                    }
                    document.getElementById('estimatedFineAmount').innerHTML = formattedFine;
                }
            });
        }
        
        const cashRadio = document.getElementById('payment_cash');
        const transferRadio = document.getElementById('payment_transfer');
        const paymentHidden = document.getElementById('payment_method_selected');
        const transferInfo = document.getElementById('transferInfo');
        const paymentOptionCash = document.getElementById('paymentOptionCash');
        const paymentOptionTransfer = document.getElementById('paymentOptionTransfer');
        
        if (cashRadio) {
            cashRadio.addEventListener('change', function() {
                if (this.checked) {
                    paymentHidden.value = 'cash';
                    if (transferInfo) transferInfo.classList.add('hidden');
                    if (paymentOptionCash) {
                        paymentOptionCash.style.borderColor = '#10b981';
                        paymentOptionCash.style.background = 'rgba(16, 185, 129, 0.1)';
                    }
                    if (paymentOptionTransfer) {
                        paymentOptionTransfer.style.borderColor = 'rgba(185,166,255,0.2)';
                        paymentOptionTransfer.style.background = '#1a1a2e';
                    }
                }
            });
        }
        
        if (transferRadio) {
            transferRadio.addEventListener('change', function() {
                if (this.checked) {
                    paymentHidden.value = 'transfer';
                    if (transferInfo) transferInfo.classList.remove('hidden');
                    if (paymentOptionTransfer) {
                        paymentOptionTransfer.style.borderColor = '#3b82f6';
                        paymentOptionTransfer.style.background = 'rgba(59, 130, 246, 0.1)';
                    }
                    if (paymentOptionCash) {
                        paymentOptionCash.style.borderColor = 'rgba(185,166,255,0.2)';
                        paymentOptionCash.style.background = '#1a1a2e';
                    }
                }
            });
        }
        
        var itemSelect = document.getElementById('item_id');
        var amountInput = document.getElementById('quantity');
        
        if (itemSelect && amountInput) {
            itemSelect.addEventListener('change', function() {
                validateStock();
                var stock = this.options[this.selectedIndex].getAttribute('data-stock');
                if (stock) {
                    amountInput.max = stock;
                    amountInput.placeholder = 'Maksimal ' + stock + ' barang';
                }
            });
            
            amountInput.addEventListener('input', function() { validateStock(); });
        }
        
        var searchInput = document.getElementById('table-search');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                var searchTerm = this.value.toLowerCase();
                var rows = document.querySelectorAll('tbody tr');
                rows.forEach(function(row) {
                    row.style.display = row.textContent.toLowerCase().indexOf(searchTerm) > -1 ? '' : 'none';
                });
            });
        }
        
        setTimeout(function() {
            var successAlert = document.getElementById('alert-success');
            var errorAlert = document.getElementById('alert-error');
            if (successAlert) successAlert.style.display = 'none';
            if (errorAlert) errorAlert.style.display = 'none';
        }, 3000);
        
        const borrowForm = document.getElementById('borrowForm');
        if (borrowForm) {
            borrowForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const itemSelect = document.getElementById('item_id');
                const amountInput = document.getElementById('quantity');
                const selectedOption = itemSelect.options[itemSelect.selectedIndex];
                const stock = selectedOption.getAttribute('data-stock');
                const amount = parseInt(amountInput.value) || 0;
                const itemName = selectedOption.getAttribute('data-name');
                const returnDate = document.getElementById('return_date').value;
                
                if (!itemSelect.value) {
                    showNotification('Silakan pilih barang terlebih dahulu', 'error');
                    return false;
                }
                
                if (amount === 0) {
                    showNotification('Silakan masukkan jumlah barang', 'error');
                    return false;
                }
                
                if (amount > parseInt(stock)) {
                    showNotification('Stok tidak mencukupi! Stok tersedia: ' + stock + ' unit', 'error');
                    return false;
                }
                
                Swal.fire({
                    title: 'Konfirmasi Peminjaman',
                    html: '<div class="text-left"><p class="mb-2">Anda akan meminjam:</p><div class="bg-[#0f0f1a] p-3 rounded-lg mb-2"><p><strong>Barang:</strong> ' + itemName + '</p><p><strong>Jumlah:</strong> ' + amount + ' unit</p><p><strong>Tanggal Kembali:</strong> ' + returnDate + '</p></div><p class="text-yellow-400 text-sm">⚠️ Pastikan data yang diisi sudah benar</p></div>',
                    icon: 'question',
                    background: '#1e1e2f',
                    color: '#fff',
                    confirmButtonColor: '#b9a6ff',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Ajukan!',
                    cancelButtonText: 'Batal',
                    showCancelButton: true,
                    customClass: { popup: 'rounded-xl border border-[rgba(185,166,255,0.2)]' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoading();
                        playSuccessSound();
                        
                        const formData = new FormData(borrowForm);
                        
                        fetch(borrowForm.action, {
                            method: 'POST',
                            body: formData,
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(response => response.json())
                        .then(data => {
                            hideLoading();
                            if (data.success) {
                                playSuccessSound();
                                showNotification(data.message || 'Peminjaman berhasil diajukan!', 'success');
                                showSweetAlert('Berhasil!', data.message || 'Peminjaman Anda telah diajukan dan akan diproses oleh petugas.', 'success');
                                borrowForm.reset();
                                document.getElementById('borrow_date').value = new Date().toISOString().slice(0,10);
                                document.getElementById('return_date').value = new Date(Date.now() + 7*24*60*60*1000).toISOString().slice(0,10);
                                setTimeout(() => window.location.reload(), 2000);
                            } else {
                                showNotification(data.message || 'Terjadi kesalahan', 'error');
                                showSweetAlert('Gagal!', data.message || 'Terjadi kesalahan saat memproses peminjaman.', 'error');
                            }
                        })
                        .catch(error => {
                            hideLoading();
                            console.error('Error:', error);
                            showNotification('Terjadi kesalahan jaringan', 'error');
                            showSweetAlert('Error!', 'Terjadi kesalahan saat menghubungi server.', 'error');
                        });
                    }
                });
            });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
@endsection