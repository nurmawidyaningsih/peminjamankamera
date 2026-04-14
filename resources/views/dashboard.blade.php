@extends('layouts.app')

@section('title', 'Dashboard - Lentora')

@section('content')
<style>
    /* ========== VIDEO SECTION ========== */
    .video-section {
        margin-left: 2rem;
        margin-right: 2rem;
        margin-top: -5rem;
        margin-bottom: 2rem;
        position: relative;
        z-index: 10;
    }
    
    .video-card {
        background: linear-gradient(135deg, rgba(26,26,46,0.98) 0%, rgba(22,33,62,0.98) 100%);
        backdrop-filter: blur(12px);
        border-radius: 1.25rem;
        border: 1px solid rgba(185,166,255,0.25);
        overflow: hidden;
        box-shadow: 0 20px 40px -12px rgba(0,0,0,0.4);
    }
    
    .video-header {
        padding: 0.875rem 1.5rem;
        background: rgba(185,166,255,0.05);
        border-bottom: 1px solid rgba(185,166,255,0.15);
    }
    
    .video-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: #d4c4ff;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .video-header h3::before {
        content: "🎬";
        font-size: 1.1rem;
    }
    
    .video-player video {
        width: 100%;
        height: auto;
        max-height: 380px;
        object-fit: cover;
        display: block;
    }
    
    /* ========== WELCOME CARD ========== */
    .welcome-section {
        margin-left: 2rem;
        margin-right: 2rem;
        margin-bottom: 2rem;
    }
    
    .welcome-card {
        background: rgba(26, 26, 46, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 1.25rem;
        border: 1px solid rgba(185, 166, 255, 0.2);
        padding: 2rem;
        box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.4);
    }
    
    /* ========== STATS CARDS ========== */
    .stats-grid {
        margin-left: 2rem;
        margin-right: 2rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: #1e1e2f;
        border-radius: 1rem;
        padding: 1.25rem;
        border: 1px solid rgba(185, 166, 255, 0.15);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        border-color: rgba(185, 166, 255, 0.4);
        box-shadow: 0 10px 25px -8px rgba(185, 166, 255, 0.15);
    }
    
    .stat-number {
        font-size: 1.75rem;
        font-weight: 700;
        color: white;
        margin-top: 0.5rem;
    }
    
    .stat-icon {
        width: 2.75rem;
        height: 2.75rem;
        background: linear-gradient(135deg, #b9a6ff, #9a87e6);
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* ========== CHART CARDS ========== */
    .chart-section {
        margin-left: 2rem;
        margin-right: 2rem;
        margin-bottom: 2rem;
    }
    
    .chart-card {
        background: #1e1e2f;
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid rgba(185, 166, 255, 0.15);
    }
    
    /* ========== ACTION CARDS ========== */
    .action-grid {
        margin-left: 2rem;
        margin-right: 2rem;
        margin-bottom: 2rem;
    }
    
    .action-card {
        background: #1e1e2f;
        border-radius: 1rem;
        padding: 1.75rem;
        text-align: center;
        border: 1px solid rgba(185, 166, 255, 0.15);
        transition: all 0.3s ease;
        display: block;
        text-decoration: none;
    }
    
    .action-card:hover {
        transform: translateY(-4px);
        border-color: rgba(185, 166, 255, 0.4);
        box-shadow: 0 12px 28px -10px rgba(185, 166, 255, 0.2);
        text-decoration: none;
    }
    
    .icon-wrapper {
        width: 3.5rem;
        height: 3.5rem;
        background: linear-gradient(135deg, #b9a6ff, #9a87e6);
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem auto;
    }
    
    /* ========== TABLE SECTION ========== */
    .table-section {
        margin-left: 2rem;
        margin-right: 2rem;
        margin-bottom: 2rem;
    }
    
    .table-container {
        background: #1e1e2f;
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid rgba(185, 166, 255, 0.15);
    }
    
    .search-input {
        background: #0f0f1a;
        border: 1px solid rgba(185, 166, 255, 0.2);
        color: white;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        width: 100%;
    }
    
    .search-input:focus {
        outline: none;
        border-color: #b9a6ff;
        box-shadow: 0 0 0 2px rgba(185, 166, 255, 0.2);
    }
    
    .btn-search {
        background: linear-gradient(135deg, #b9a6ff, #9a87e6);
        color: #1a1a2e;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-search:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(185, 166, 255, 0.3);
    }
    
    .btn-reset {
        background: #374151;
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-reset:hover {
        background: #4b5563;
        text-decoration: none;
        color: white;
    }
    
    .btn-pinjam {
        background: linear-gradient(135deg, #b9a6ff, #9a87e6);
        color: #1a1a2e;
        font-weight: 600;
        padding: 0.375rem 0.875rem;
        border-radius: 0.5rem;
        font-size: 0.813rem;
        display: inline-block;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    
    .btn-pinjam:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(185, 166, 255, 0.3);
        text-decoration: none;
        color: #1a1a2e;
    }
    
    .status-available {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.688rem;
        font-weight: 500;
        display: inline-block;
    }
    
    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .video-section,
        .welcome-section,
        .stats-grid,
        .chart-section,
        .action-grid,
        .table-section {
            margin-left: 1rem;
            margin-right: 1rem;
        }
        
        .video-section {
            margin-top: -3rem;
        }
        
        .video-player video {
            max-height: 200px;
        }
        
        .welcome-card {
            padding: 1.25rem;
        }
        
        .stat-number {
            font-size: 1.25rem;
        }
        
        .stat-icon {
            width: 2.25rem;
            height: 2.25rem;
        }
        
        .table-container {
            padding: 1rem;
        }
        
        .btn-search,
        .btn-reset {
            padding: 0.375rem 1rem;
            font-size: 0.813rem;
        }
    }
    
    @media (min-width: 768px) and (max-width: 1024px) {
        .video-section,
        .welcome-section,
        .stats-grid,
        .chart-section,
        .action-grid,
        .table-section {
            margin-left: 1.5rem;
            margin-right: 1.5rem;
        }
        
        .video-section {
            margin-top: -4rem;
        }
        
        .video-player video {
            max-height: 300px;
        }
    }
</style>

<div>
    <!-- Header -->
    <div class="header-gradient flex flex-col items-start justify-start px-4 py-4 h-56 mb-4">
        <div class="relative z-10">
            <p class="text-sm text-white">Pages / Home</p>
            <p class="text-xl font-bold text-white">Dashboard</p>
        </div>
    </div>
    
    <!-- Video Section -->
    <div class="video-section">
        <div class="video-card">
            <div class="video-header">
                <h3>Sewa Kamera</h3>
            </div>
            <div class="video-player">
                <video 
                    controls
                    autoplay
                    muted
                    loop
                    playsinline
                    preload="metadata"
                >
                    <source src="{{ asset('video/kamera.mp4') }}" type="video/mp4">
                    <source src="{{ asset('video/kamera.webm') }}" type="video/webm">
                    Browser Anda tidak mendukung tag video.
                </video>
            </div>
        </div>
    </div>
    
    <!-- Welcome Card -->
    <div class="welcome-section">
        <div class="welcome-card">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                <div class="flex-1 text-center lg:text-left">
                    <h1 class="text-xl lg:text-2xl font-bold text-white mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-sm text-white mb-4">
                        PinjamPro helps you manage your inventory seamlessly, from tracking to updating stock items with ease.
                    </p>
                    <a href="#semua-barang" class="bg-gradient-to-r from-[#b9a6ff] to-[#9a87e6] text-white font-semibold px-5 py-2 rounded-lg hover:shadow-lg transition-all inline-block text-sm">
                        Lihat Semua Barang
                    </a>
                </div>
                <div class="camera-illustration">
                    <svg width="140" height="140" viewBox="0 0 280 280" fill="none" class="lg:w-[160px] lg:h-[160px] w-[120px] h-[120px]">
                        <circle cx="140" cy="140" r="100" fill="url(#pulseGradient)" opacity="0.3"/>
                        <rect x="60" y="80" width="160" height="100" rx="20" fill="url(#cameraGradient)" stroke="url(#strokeGradient)" stroke-width="2"/>
                        <circle cx="120" cy="130" r="30" fill="url(#lensGradient)" stroke="white" stroke-width="2"/>
                        <circle cx="120" cy="130" r="20" fill="url(#lensInnerGradient)"/>
                        <circle cx="190" cy="110" r="6" fill="white"/>
                        <circle cx="70" cy="110" r="5" fill="#4ade80"/>
                        <defs>
                            <linearGradient id="cameraGradient"><stop stop-color="#2a2a40"/><stop offset="1" stop-color="#1a1a2e"/></linearGradient>
                            <linearGradient id="lensGradient"><stop stop-color="#b9a6ff"/><stop offset="1" stop-color="#9a87e6"/></linearGradient>
                            <linearGradient id="lensInnerGradient"><stop stop-color="#d4c4ff"/><stop offset="1" stop-color="#b9a6ff"/></linearGradient>
                            <linearGradient id="strokeGradient"><stop stop-color="#b9a6ff"/><stop offset="1" stop-color="#d4c4ff"/></linearGradient>
                            <radialGradient id="pulseGradient"><stop stop-color="#b9a6ff" stop-opacity="0.2"/><stop offset="1" stop-color="#b9a6ff" stop-opacity="0"/></radialGradient>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-white">Total Items</p>
                        <p class="stat-number">{{ $totalItems ?? 0 }}</p>
                    </div>
                    <div class="stat-icon">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 18 18">
                            <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-white">Items Tersedia</p>
                        <p class="stat-number">{{ $availableItems ?? 0 }}</p>
                    </div>
                    <div class="stat-icon">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 0 0 2v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-white">Barang Dipinjam</p>
                        <p class="stat-number">{{ $borrowItems ?? 0 }}</p>
                    </div>
                    <div class="stat-icon">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-white">Total Users</p>
                        <p class="stat-number">{{ $totalUsers ?? 0 }}</p>
                    </div>
                    <div class="stat-icon">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="chart-section">
        <div class="chart-card">
            <h2 class="text-lg lg:text-xl font-bold mb-5 text-white">📊 Statistik Peminjaman & Pengembalian</h2>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <h3 class="text-white mb-3 text-sm font-medium">
                        <span class="w-2 h-2 rounded-full bg-[#b9a6ff] inline-block mr-2"></span>
                        Peminjaman & Pengembalian (7 Hari Terakhir)
                    </h3>
                    <div class="h-80">
                        <canvas id="combinedChart"></canvas>
                    </div>
                </div>
            </div>
            <p class="mt-4 text-xs text-center text-sm text-white">Data statistik 7 hari terakhir</p>
        </div>
    </div>

    <!-- Action Cards -->
    <div class="action-grid">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <a href="{{ route('pinjamBarang') }}" class="action-card">
                <div class="icon-wrapper">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold mb-2 text-white">Peminjaman</h2>
                <p class="text-[#e0e0e0] mb-3 text-sm text-white">Lakukan peminjaman barang dengan mudah</p>
                <span class="text-[#b9a6ff] font-medium text-sm text-white">Klik Disini →</span>
            </a>
            <a href="{{ route('pinjamBarang') }}" class="action-card">
                <div class="icon-wrapper">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold mb-2 text-white">Pengembalian</h2>
                <p class="text-[#e0e0e0] mb-3 text-sm text-white">Kembalikan barang yang sudah dipinjam</p>
                <span class="text-[#b9a6ff] font-medium text-sm text-white">Klik Disini →</span>
            </a>
        </div>
    </div>

    <!-- Table Section -->
    <div id="semua-barang" class="table-section">
        <div class="table-container">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-5">
                <h2 class="text-lg lg:text-xl font-bold text-white">📦 Daftar Semua Barang</h2>
                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama barang..." class="search-input w-56 text-sm">
                    <button type="submit" class="btn-search text-sm">Cari</button>
                    @if(isset($search) && $search)
                        <a href="{{ route('dashboard') }}" class="btn-reset text-sm">Reset</a>
                    @endif
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#2a2a40]">
                        <tr>
                            <th class="p-3 text-xs text-white">No</th>
                            <th class="p-3 text-xs text-white">Nama Barang</th>
                            <th class="p-3 text-xs text-white hidden sm:table-cell">Deskripsi</th>
                            <th class="p-3 text-xs text-white">Stok</th>
                            <th class="p-3 text-xs text-white">Kondisi</th>
                            @if(auth()->user()->role === 'user')
                                <th class="p-3 text-xs text-white">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                        <tr class="border-b border-[rgba(185,166,255,0.1)] hover:bg-[rgba(185,166,255,0.05)] transition-colors">
                            <td class="p-3 text-sm text-white">{{ $loop->iteration }}</td>
                            <td class="p-3 font-medium text-white text-sm">{{ $item->name }}</td>
                            <td class="p-3 text-white text-sm hidden sm:table-cell">{{ Str::limit($item->description ?? '-', 40) }}</td>
                            <td class="p-3 text-white text-sm">{{ $item->stock ?? 0 }}</td>
                            <td class="p-3">
                                <span class="status-available text-xs">Tersedia</span>
                            </td>
                            @if(auth()->user()->role === 'user')
                            <td class="p-3">
                                @if(($item->stock ?? 0) > 0)
                                    <a href="{{ route('pinjamBarang') }}?item_id={{ $item->id }}" class="btn-pinjam text-xs">Pinjam</a>
                                @else
                                    <button class="bg-gray-600 text-white px-2 py-1 rounded-lg text-xs opacity-50 cursor-not-allowed" disabled>Tidak Tersedia</button>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'user' ? '6' : '5' }}" class="p-4 text-center text-white text-sm">
                                Tidak ada barang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Alert Scripts -->
@if (session('success'))
    <div id="alert-success" class="fixed top-4 right-4 z-50 flex items-center p-3 rounded-lg bg-[#1e1e2f] border border-green-500/30 shadow-lg">
        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 0 0 2v4h1a1 1 0 0 1 0 2Z"/></svg>
        <span class="text-green-400 text-sm">{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div id="alert-error" class="fixed top-4 right-4 z-50 flex items-center p-3 rounded-lg bg-[#1e1e2f] border border-red-500/30 shadow-lg">
        <svg class="w-4 h-4 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 0 0 2v4h1a1 1 0 0 1 0 2Z"/></svg>
        <span class="text-red-400 text-sm">{{ session('error') }}</span>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    setTimeout(function() {
        const success = document.getElementById('alert-success');
        const error = document.getElementById('alert-error');
        if (success) success.style.display = 'none';
        if (error) error.style.display = 'none';
    }, 3000);

    // Chart Data untuk 7 hari terakhir
    const labels = @json($labels);
    const borrowData = @json($borrowData);
    const returnData = @json($returnData);

    document.addEventListener('DOMContentLoaded', function() {
        const combinedCtx = document.getElementById('combinedChart');
        if (combinedCtx) {
            new Chart(combinedCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Peminjaman',
                            data: borrowData,
                            borderColor: '#b9a6ff',
                            backgroundColor: 'rgba(185, 166, 255, 0.05)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#b9a6ff',
                            pointBorderColor: '#1e1e2f',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Pengembalian',
                            data: returnData,
                            borderColor: '#7ed6df',
                            backgroundColor: 'rgba(126, 214, 223, 0.05)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#7ed6df',
                            pointBorderColor: '#1e1e2f',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#b4b4d2',
                                font: { size: 12 },
                                usePointStyle: true,
                                boxWidth: 10
                            },
                            position: 'top'
                        },
                        tooltip: {
                            backgroundColor: '#1e1e2f',
                            titleColor: '#b9a6ff',
                            bodyColor: '#e0e0e0',
                            borderColor: '#b9a6ff',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let value = context.raw || 0;
                                    return `${label}: ${value} transaksi`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(185,166,255,0.08)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#b4b4d2',
                                font: { size: 11 },
                                stepSize: 1,
                                callback: function(value) {
                                    return value + ' transaksi';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Transaksi',
                                color: '#b4b4d2',
                                font: { size: 11 }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                color: '#b4b4d2',
                                font: { size: 11 }
                            },
                            title: {
                                display: true,
                                text: 'Tanggal',
                                color: '#b4b4d2',
                                font: { size: 11 }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });
        }
    });
</script>
@endsection