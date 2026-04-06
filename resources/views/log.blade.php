@extends('layouts.app')

@section('title', 'Log Aktivitas - Lentora')

@section('content')
<style>
    :root {
        --primary-color: #b9a6ff;
        --primary-dark: #9a87e6;
        --primary-light: #d4c4ff;
        --secondary-color: #1a1a2e;
        --bg-card: #1e1e2f;
        --bg-dark: #0f0f1a;
        --text-light: #ffffff;
        --text-soft: #e0e0e0;
        --border-dark: rgba(185, 166, 255, 0.2);
    }
    
    .badge-action.borrow {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .badge-action.return {
        background-color: #2d2a4e;
        color: var(--primary-light);
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid var(--primary-color);
    }
    
    .btn-delete-log {
        color: #ff6b6b;
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        background: rgba(255, 107, 107, 0.1);
        border: 1px solid transparent;
        transition: all 0.3s ease;
    }
    
    .btn-delete-log:hover {
        background: rgba(255, 107, 107, 0.2);
        border-color: #ff6b6b;
    }
    
    .table-header th {
        color: white !important;
    }
    
    .search-input {
        background: rgba(26, 26, 46, 0.9);
        border: 1px solid var(--border-dark);
        color: #e0e0e0;
        padding-left: 2.5rem;
        border-radius: 0.5rem;
    }
    
    .search-input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(185, 166, 255, 0.2);
    }
    
    .header-gradient {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        position: relative;
        overflow: hidden;
    }
</style>

<div class="rounded-lg">
    <!-- Header -->
    <div class="header-gradient flex flex-col items-start justify-start px-4 py-4 mb-4">
        <div class="relative z-10">
            <p class="text-sm text-white">Pages / Log Aktivitas</p>
            <p class="text-xl font-bold text-white">Log Aktivitas</p>
        </div>
    </div>
    
    <!-- Content Card -->
    <div class="flex flex-col justify-around gap-4 mx-4 lg:mx-10 -mt-36 mb-4 p-4 lg:p-8 rounded-xl" style="background-color: var(--bg-card); border: 1px solid var(--border-dark);">
        <div class="flex flex-col gap-3 justify-start items-start p-4 lg:p-0">
            <h1 class="text-xl lg:text-2xl font-bold text-white">📋 Log Aktivitas</h1>
            <p class="text-sm text-white">Riwayat peminjaman dan pengembalian barang</p>
        </div>
        
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="background-color: var(--bg-card); border: 1px solid var(--border-dark);">
            <div class="pb-4 p-4" style="background-color: var(--bg-card);">
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block pt-2 ps-10 text-sm rounded-lg w-full lg:w-80 search-input" 
                        placeholder="Cari berdasarkan nama pengguna...">
                </div>
            </div>
            
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase table-header">
                    <tr class="border-b border-[rgba(185,166,255,0.2)]">
                        <th class="p-3 lg:p-4 text-white">No.</th>
                        <th class="px-3 lg:px-6 py-3 text-white">Username</th>
                        <th class="px-3 lg:px-6 py-3 text-white">Barang</th>
                        <th class="px-3 lg:px-6 py-3 text-white">Jumlah</th>
                        <th class="px-3 lg:px-6 py-3 text-white">Status</th>
                        <th class="px-3 lg:px-6 py-3 text-white">Waktu</th>
                        <th class="px-3 lg:px-6 py-3 text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                    <tr class="border-b" style="border-bottom-color: var(--border-dark);">
                        <td class="p-3 lg:p-4">
                            <p class="text-md font-bold text-white">{{ $loop->iteration }}</p>
                        </td>
                        <th scope="row" class="px-3 lg:px-6 py-4 font-medium whitespace-nowrap text-white">
                            {{ $log->user->name ?? 'System' }}
                        </th>
                        <td class="px-3 lg:px-6 py-4 text-white">
                           {{ $log->item->name ?? 'Barang dihapus' }}
                        </td>
                        <td class="px-3 lg:px-6 py-4 text-white">
                            {{ $log->amount }}
                        </td>
                        <td class="px-3 lg:px-6 py-4">
                            @if($log->action == 'borrowed' || $log->action == 'pinjam')
                                <span class="badge-action borrow">Dipinjam</span>
                            @else
                                <span class="badge-action return">Dikembalikan</span>
                            @endif
                        </td>
                        <td class="px-3 lg:px-6 py-4 text-white">
                            {{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td class="px-3 lg:px-6 py-4">
                            <button type="button" data-modal-target="popup-modal-{{ $log->id }}" 
                                    data-modal-toggle="popup-modal-{{ $log->id }}" 
                                    class="btn-delete-log font-medium">
                                Hapus Log
                            </button>
                            
                            <!-- Modal Konfirmasi Hapus -->
                            <div id="popup-modal-{{ $log->id }}" tabindex="-1" 
                                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative rounded-lg shadow" style="background-color: var(--bg-card); border: 1px solid var(--border-dark);">
                                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" 
                                                data-modal-hide="popup-modal-{{ $log->id }}">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-4 md:p-5 text-center">
                                            <svg class="mx-auto mb-4 w-12 h-12" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-white">Hapus log aktivitas ini?</h3>
                                            <p class="text-sm text-white mb-4">Data yang dihapus tidak dapat dikembalikan.</p>
                                            <form action="{{ route('logs.delete', $log->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center" 
                                                        style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
                                                    Ya, Hapus
                                                </button>
                                            </form>
                                            <button data-modal-hide="popup-modal-{{ $log->id }}" type="button" 
                                                    class="py-2.5 px-5 ms-3 text-sm font-medium rounded-lg border focus:z-10 focus:ring-4"
                                                    style="color: var(--text-soft); background-color: transparent; border-color: var(--border-dark);">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="w-16 h-16 text-[#6b6b8b] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-lg text-white">Belum ada data log aktivitas</p>
                                <p class="text-sm text-white mt-1">Aktivitas peminjaman dan pengembalian akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if (session('success'))
<div id="alert-success" class="fixed top-4 right-4 z-50 flex items-center p-4 rounded-lg shadow-lg animate-slide-in"
     style="background-color: #1a3a2e; border: 1px solid #2ecc71;">
    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 0 0 2v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <span class="text-green-400">{{ session('success') }}</span>
</div>
@endif

@if (session('error'))
<div id="alert-error" class="fixed top-4 right-4 z-50 flex items-center p-4 rounded-lg shadow-lg animate-slide-in"
     style="background-color: #3a1a2e; border: 1px solid #e74c3c;">
    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 0 0 2v4h1a1 1 0 0 1 0 2Z"/>
    </svg>
    <span class="text-red-400">{{ session('error') }}</span>
</div>
@endif

<script>
    // Search functionality
    const searchInput = document.getElementById('table-search');
    const tableRows = document.querySelectorAll('tbody tr');

    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = searchInput.value.toLowerCase();
            
            tableRows.forEach(row => {
                const userName = row.querySelector('th')?.textContent.toLowerCase() || '';
                if (userName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Auto hide alerts after 3 seconds
    setTimeout(() => {
        const successAlert = document.getElementById('alert-success');
        const errorAlert = document.getElementById('alert-error');
        if (successAlert) successAlert.style.display = 'none';
        if (errorAlert) errorAlert.style.display = 'none';
    }, 3000);
    
    // Add animation style
    const style = document.createElement('style');
    style.textContent = `
        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);
</script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
@endsection