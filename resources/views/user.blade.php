@extends('layouts.app')

@section('title', 'List User - Lentora')

@section('content')
<style>
    /* Badge styles untuk role */
    .badge-admin {
        background: linear-gradient(135deg, #b9a6ff 0%, #9a87e6 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-petugas {
        background-color: #2a2a40;
        color: #b4b4d2;
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid #2d2d44;
        display: inline-block;
    }

    .badge-user {
        background-color: #1a3a2e;
        color: #7bed9f;
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid #2d5a4e;
        display: inline-block;
    }
    
    .btn-add-user {
        background: linear-gradient(135deg, #b9a6ff 0%, #9a87e6 100%);
        color: #1a1a2e;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-add-user:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(185, 166, 255, 0.3);
    }
    
    .search-input-user {
        background: rgba(26, 26, 46, 0.9);
        border: 1px solid rgba(185, 166, 255, 0.2);
        color: #e0e0e0;
        padding-left: 2.5rem;
        border-radius: 0.5rem;
        width: 100%;
    }
    
    .search-input-user:focus {
        border-color: #b9a6ff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(185, 166, 255, 0.2);
    }
    
    /* Table header white color */
    .table-header th {
        color: white !important;
    }
    
    /* Ikon pencarian warna putih */
    .search-icon {
        color: white !important;
    }
    
    @media (max-width: 768px) {
        .mx-10 {
            margin-left: 1rem;
            margin-right: 1rem;
        }
        .p-8 {
            padding: 1rem;
        }
        .table-container {
            overflow-x: auto;
        }
    }
</style>

<div class="rounded-lg">
    <!-- Header -->
    <div class="header-gradient flex flex-col items-start justify-start px-4 py-4 mb-4">
        <div class="relative z-10">
            <p class="text-md text-white">Pages / List User</p>
            <p class="text-lg font-bold text-white">List User</p>
        </div>
    </div>
    
    <!-- Content Card -->
    <div class="flex flex-col justify-around gap-4 mx-4 lg:mx-10 -mt-36 mb-4 p-4 lg:p-8 rounded-xl content-card">
        <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center p-4 lg:p-0">
            <div>
                <h1 class="text-xl lg:text-2xl font-bold text-white">👥 List Users</h1>
                <p class="text-sm text-white mt-1">Kelola data pengguna sistem</p>
            </div>
            <button data-modal-target="adduser-modal" data-modal-toggle="adduser-modal" 
                class="btn-add-user inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah User
            </button>
        </div>
        
        <div class="relative overflow-x-auto table-container">
            <div class="pb-4 bg-transparent p-4">
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 search-icon" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block pt-2 ps-10 text-sm rounded-lg w-full lg:w-80 search-input-user" 
                        placeholder="Cari berdasarkan nama pengguna...">
                </div>
            </div>
            
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase table-header">
                    <tr>
                        <th class="p-3 lg:p-4">No.</th>
                        <th class="px-3 lg:px-6 py-3">Username</th>
                        <th class="px-3 lg:px-6 py-3 hidden sm:table-cell">Email</th>
                        <th class="px-3 lg:px-6 py-3 hidden md:table-cell">Password</th>
                        <th class="px-3 lg:px-6 py-3">Roles</th>
                        <th class="px-3 lg:px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="border-b table-row" style="border-bottom-color: var(--border-dark);">
                        <td class="p-3 lg:p-4 text-white">{{ $loop->iteration }}</td>
                        <td class="px-3 lg:px-6 py-4 font-medium text-white">{{ $user->name }}</td>
                        <td class="px-3 lg:px-6 py-4 text-[#e0e0e0] hidden sm:table-cell">{{ $user->email }}</td>
                        <td class="px-3 lg:px-6 py-4 text-[#e0e0e0] hidden md:table-cell">••••••••</td>
                        <td class="px-3 lg:px-6 py-4">
                            @if($user->role == 'admin')
                                <span class="badge-admin">Admin</span>
                            @elseif($user->role == 'petugas')
                                <span class="badge-petugas">Petugas</span>
                            @else
                                <span class="badge-user">User</span>
                            @endif
                        </td>
                        <td class="px-3 lg:px-6 py-4">
                            <button data-modal-target="edit-modal-{{ $user->id }}" data-modal-toggle="edit-modal-{{ $user->id }}"
                                class="font-medium hover:underline" style="color: var(--primary-color);" type="button">
                                Edit
                            </button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 hover:underline ml-3">Hapus</button>
                            </form>
                            
                            <!-- Modal Edit User -->
                            <div id="edit-modal-{{ $user->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <div class="relative rounded-lg shadow" style="background-color: var(--bg-card); border: 1px solid var(--border-dark);">
                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t" style="border-bottom-color: var(--border-dark);">
                                            <h3 class="text-xl font-semibold text-white">Edit User</h3>
                                            <button type="button" class="text-gray-400 hover:text-white" data-modal-hide="edit-modal-{{ $user->id }}">✕</button>
                                        </div>
                                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="p-4 md:p-5 space-y-4">
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-[#d4c4ff]">Nama User</label>
                                                    <input type="text" name="name" value="{{ $user->name }}" 
                                                        class="w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" required>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-[#d4c4ff]">Email</label>
                                                    <input type="email" name="email" value="{{ $user->email }}" 
                                                        class="w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" required>
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-[#d4c4ff]">Password (Kosongkan jika tidak diubah)</label>
                                                    <input type="password" name="password" 
                                                        class="w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" placeholder="********">
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-[#d4c4ff]">Konfirmasi Password</label>
                                                    <input type="password" name="password_confirmation" 
                                                        class="w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" placeholder="********">
                                                </div>
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-[#d4c4ff]">Role</label>
                                                    <select name="role" class="w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" required>
                                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                        <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="flex items-center p-4 md:p-5 border-t" style="border-top-color: var(--border-dark);">
                                                <button type="submit" class="bg-gradient-to-r from-[#b9a6ff] to-[#9a87e6] text-[#1a1a2e] font-semibold px-5 py-2 rounded-lg">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="w-16 h-16 text-[#6b6b8b] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <p class="text-lg text-[#e0e0e0]">Belum ada data user</p>
                                <p class="text-sm text-[#9ca3af] mt-1">Klik tombol "Tambah User" untuk menambahkan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->count() > 0)
        <div class="mt-4 text-right">
            <p class="text-sm text-[#9ca3af]">Total user: <span class="text-white font-semibold">{{ $users->count() }}</span></p>
        </div>
        @endif
    </div>
</div>

<!-- Modal Tambah User -->
<div id="adduser-modal" tabindex="-1" aria-hidden="true" 
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative rounded-lg shadow" style="background-color: var(--bg-card); border: 1px solid var(--border-dark);">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t" style="border-bottom-color: var(--border-dark);">
                <h3 class="text-xl font-semibold text-white">Tambah User Baru</h3>
                <button type="button" class="text-gray-400 hover:text-white" data-modal-hide="adduser-modal">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            <form action="{{ route('users') }}" method="POST">
                @csrf
                <div class="p-4 md:p-5 space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#d4c4ff]">Nama Lengkap</label>
                        <input type="text" name="name" 
                            class="w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white"
                            placeholder="John Doe" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#d4c4ff]">Email</label>
                        <input type="email" name="email" 
                            class="w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white"
                            placeholder="email@example.com" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#d4c4ff]">Password</label>
                        <input type="password" name="password" 
                            class="w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white"
                            placeholder="********" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#d4c4ff]">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" 
                            class="w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white"
                            placeholder="********" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-[#d4c4ff]">Role</label>
                        <select name="role" class="w-full p-2 rounded-lg bg-[#0f0f1a] border border-[rgba(185,166,255,0.2)] text-white" required>
                            <option value="user">User</option>
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-4 md:p-5 border-t" style="border-top-color: var(--border-dark);">
                    <button type="submit" class="bg-gradient-to-r from-[#b9a6ff] to-[#9a87e6] text-[#1a1a2e] font-semibold px-5 py-2 rounded-lg">Tambah User</button>
                </div>
            </form>
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
                const userName = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
                if (userName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Auto hide alerts
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
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
</script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
@endsection