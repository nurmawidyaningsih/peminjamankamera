@extends('layouts.app')

@section('title', 'Inventaris - Lentora')

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
    
    .table-container {
        background: rgba(26, 26, 46, 0.9);
        border: 1px solid rgba(185, 166, 255, 0.15);
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .table-header {
        background: linear-gradient(90deg, rgba(185, 166, 255, 0.15) 0%, rgba(154, 135, 230, 0.1) 100%);
    }
    
    .table-header th {
        color: white !important;
    }
    
    .table-row {
        border-bottom: 1px solid rgba(185, 166, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .table-row:hover {
        background: rgba(185, 166, 255, 0.08);
    }
    
    .table-row td {
        color: white !important;
    }
    
    .table-row td:first-child,
    .table-row td:nth-child(5) {
        color: white !important;
        font-weight: 500;
    }
    
    .search-input {
        background: rgba(26, 26, 46, 0.9);
        border: 1px solid var(--border-dark);
        color: var(--text-soft);
        padding-left: 2.5rem;
        border-radius: 0.5rem;
        width: 100%;
    }
    
    .search-input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(185, 166, 255, 0.2);
    }
    
    .search-icon {
        color: white !important;
    }
    
    .btn-primary {
        background: linear-gradient(90deg, #b9a6ff 0%, #9a87e6 100%);
        color: white !important;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(185, 166, 255, 0.3);
    }
    
    .edit-btn {
        color: #b9a6ff;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .edit-btn:hover {
        text-decoration: underline;
        opacity: 0.8;
    }
    
    /* Button styles - white text */
    .btn-save {
        background: linear-gradient(135deg, #b9a6ff 0%, #9a87e6 100%);
        color: white !important;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(185, 166, 255, 0.3);
    }
    
    /* Tombol Tambah Barang - dengan latar ungu gradient */
    .btn-add-item {
        background: linear-gradient(135deg, #b9a6ff 0%, #9a87e6 100%);
        color: white !important;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .btn-add-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(185, 166, 255, 0.4);
    }
    
    /* File input styling */
    .file-upload-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    
    .file-input-label {
        cursor: pointer;
        padding: 10px 20px;
        background: linear-gradient(135deg, #b9a6ff 0%, #9a87e6 100%);
        color: #1a1a2e;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
        width: auto;
        min-width: 150px;
    }
    
    .file-input-label:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(185, 166, 255, 0.3);
        cursor: pointer;
    }
    
    .file-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .file-name-display {
        margin-top: 8px;
        font-size: 0.75rem;
        color: #9ca3af;
        display: block;
    }
    
    .photo-preview {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 0.75rem;
        border: 2px solid #b9a6ff;
        background: #0f0f1a;
    }
    
    .photo-preview-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-bottom: 20px;
    }
    
    /* Custom modal styles */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }
    
    .custom-modal.active {
        display: flex;
    }
    
    .custom-modal-content {
        background: #1a1a2e;
        border: 1px solid rgba(185, 166, 255, 0.2);
        border-radius: 1rem;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        animation: modalFadeIn 0.3s ease;
    }
    
    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .custom-modal-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(185, 166, 255, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        background: #1a1a2e;
        z-index: 10;
    }
    
    .custom-modal-body {
        padding: 1.5rem;
    }
    
    .custom-modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(185, 166, 255, 0.2);
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        position: sticky;
        bottom: 0;
        background: #1a1a2e;
    }
    
    .close-modal {
        background: none;
        border: none;
        color: #9ca3af;
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.3s;
        line-height: 1;
    }
    
    .close-modal:hover {
        color: white;
    }
    
    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        background: #0f0f1a;
        border: 1px solid rgba(185, 166, 255, 0.2);
        color: white;
        transition: all 0.3s;
    }
    
    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #b9a6ff;
        box-shadow: 0 0 0 2px rgba(185, 166, 255, 0.2);
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #d4c4ff;
    }
    
    .required-star {
        color: #ef4444;
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
    
    .animate-slide-in {
        animation: slideInRight 0.3s ease-out;
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
        
        .custom-modal-content {
            width: 95%;
            margin: 1rem;
        }
        
        .btn-add-item {
            padding: 0.4rem 1rem;
            font-size: 0.75rem;
        }
    }
</style>

<div class="rounded-lg">
    <!-- Header -->
    <div class="header-gradient flex flex-col items-start justify-start px-4 py-4 mb-4">
        <div class="relative z-10">
            <p class="text-md text-white">Pages / Inventaris</p>
            <p class="text-lg font-bold text-white">Inventaris Barang</p>
        </div>
    </div>
    
    <!-- Content Card -->
    <div class="flex flex-col justify-around gap-4 mx-4 lg:mx-10 -mt-36 mb-4 p-4 lg:p-8 rounded-xl content-card">
        <div class="flex flex-col lg:flex-row gap-6 justify-between items-start lg:items-center p-4 lg:p-0">
            <h1 class="text-xl lg:text-2xl font-bold text-white">📦 List Inventaris</h1>
            @if(in_array(auth()->user()->role, ['admin', 'petugas']))
            <button onclick="openAddModal()" class="btn-add-item">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Barang
            </button>
            @endif
        </div>
        
        <div class="relative overflow-x-auto table-container">
            <div class="pb-4 bg-transparent p-4">
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 search-icon" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block pt-2 ps-10 text-sm rounded-lg w-full lg:w-80 search-input" placeholder="Cari barang...">
                </div>
            </div>
            
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase table-header">
                    <tr>
                        <th class="p-3 lg:p-4">No.</th>
                        <th class="px-3 lg:px-6 py-3">Foto</th>
                        <th class="px-3 lg:px-6 py-3">Nama Barang</th>
                        <th class="px-3 lg:px-6 py-3">Deskripsi</th>
                        <th class="px-3 lg:px-6 py-3">Stok</th>
                        <th class="px-3 lg:px-6 py-3">Harga / Hari</th>
                        <th class="px-3 lg:px-6 py-3">Kondisi</th>
                        @if(in_array(auth()->user()->role, ['admin', 'petugas']))
                        <th class="px-3 lg:px-6 py-3">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                    <tr class="table-row">
                        <td class="p-3 lg:p-4 text-white">{{ $loop->iteration }}</td>
                        <td class="px-3 lg:px-6 py-4">
                            @if($item->foto)
                                <img src="{{ asset('assets/img/' . $item->foto) }}" alt="{{ $item->name }}" class="w-12 h-12 lg:w-16 lg:h-16 object-cover rounded-lg">
                            @else
                                <div class="w-12 h-12 lg:w-16 lg:h-16 bg-[#2a2a40] rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 lg:w-8 lg:h-8 text-[#b4b4d2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-3 lg:px-6 py-4 font-medium text-white">{{ $item->name }}</td>
                        <td class="px-3 lg:px-6 py-4 text-[#e0e0e0]"> {{ Str::limit($item->description ?? '-', 50) }}</td>
                       <td class="px-3 lg:px-6 py-4 text-white">{{ $item->stock ?? 0 }}</td>

<td class="px-3 lg:px-6 py-4 text-green-400 font-semibold">
    Rp {{ number_format($item->harga_sewa_perhari ?? 0, 0, ',', '.') }}
</td>

<td class="px-3 lg:px-6 py-4">
                            @if($item->kondisi == 'baik')
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-green-500/20 text-green-400">Baik</span>
                            @elseif($item->kondisi == 'rusak')
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-red-500/20 text-red-400">Rusak</span>
                            @elseif($item->kondisi == 'perbaikan')
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-yellow-500/20 text-yellow-400">Perbaikan</span>
                            @else
                                <span class="text-xs font-medium px-2 py-1 rounded-full bg-gray-500/20 text-gray-400">{{ $item->kondisi }}</span>
                            @endif
                        </td>
                        @if(in_array(auth()->user()->role, ['admin', 'petugas']))
                        <td class="px-3 lg:px-6 py-4">
                            <button onclick="openEditModal({{ $item->id }})" class="edit-btn font-medium hover:underline" type="button">
                                Edit
                            </button>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 hover:underline ml-3">Hapus</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ in_array(auth()->user()->role, ['admin', 'petugas']) ? '8' : '7' }}" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center py-8">
                                <svg class="w-16 h-16 text-[#6b6b8b] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-lg text-white">Belum ada data barang</p>
                                <p class="text-sm text-gray-400 mt-1">Klik tombol "Tambah Barang" untuk menambahkan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($items->count() > 0)
        <div class="mt-4 text-right px-4">
            <p class="text-sm text-gray-400">Total barang: <span class="text-white font-semibold">{{ $items->count() }}</span></p>
        </div>
        @endif
    </div>
</div>

<!-- Modal Edit -->
@foreach ($items as $item)
<div id="edit-modal-{{ $item->id }}" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="text-xl font-semibold text-white">Edit Barang</h3>
            <button class="close-modal" onclick="closeEditModal({{ $item->id }})">&times;</button>
        </div>
        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="custom-modal-body">
                <div class="photo-preview-container">
                    @if($item->foto)
                        <img id="preview-{{ $item->id }}" src="{{ asset('assets/img/' . $item->foto) }}" alt="Preview" class="photo-preview">
                    @else
                        <img id="preview-{{ $item->id }}" src="https://via.placeholder.com/120?text=No+Image" alt="Preview" class="photo-preview">
                    @endif
                </div>
                
                <div class="mb-4">
                    <div class="file-upload-wrapper">
                        <label class="file-input-label">📷 Pilih Foto</label>
                        <input type="file" name="foto" class="file-input" accept="image/*" onchange="previewImage(this, 'preview-{{ $item->id }}', '{{ $item->id }}')">
                    </div>
                    <span id="file-name-{{ $item->id }}" class="file-name-display">Tidak ada file dipilih</span>
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah foto</p>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Nama Barang <span class="required-star">*</span></label>
                    <input type="text" name="name" value="{{ $item->name }}" class="form-input" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="3" class="form-textarea">{{ $item->description }}</textarea>
                </div>
                
               <div class="mb-4">
    <label class="form-label">Stok <span class="required-star">*</span></label>
    <input type="number" name="stock" value="{{ $item->stock }}" class="form-input" required min="0">
</div>

<div class="mb-4">
    <label class="form-label">Harga Sewa per Hari <span class="required-star">*</span></label>
    <input 
        type="number"
        name="harga_sewa_perhari"
        value="{{ $item->harga_sewa_perhari }}"
        class="form-input"
        required
        min="0"
        placeholder="Contoh: 15000">
</div>


                
                <div class="mb-4">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-select">
                        <option value="baik" {{ $item->kondisi == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ $item->kondisi == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="perbaikan" {{ $item->kondisi == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    </select>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" onclick="closeEditModal({{ $item->id }})" class="px-4 py-2 rounded-lg border border-gray-500 text-gray-400 hover:text-white transition-colors">Batal</button>
                <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Modal Tambah Barang -->
<div id="add-modal" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="text-xl font-semibold text-white">Tambah Barang Baru</h3>
            <button class="close-modal" onclick="closeAddModal()">&times;</button>
        </div>
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="custom-modal-body">
                <div class="photo-preview-container">
                    <img id="preview-add" src="https://via.placeholder.com/120?text=Preview" alt="Preview" class="photo-preview">
                </div>
                
                <div class="mb-4">
                    <div class="file-upload-wrapper">
                        <label class="file-input-label">📷 Pilih Foto</label>
                        <input type="file" name="foto" class="file-input" accept="image/*" onchange="previewImageAdd(this)" required>
                    </div>
                    <span id="file-name-add" class="file-name-display">Tidak ada file dipilih</span>
                    <p class="text-xs text-gray-400 mt-1">* Foto wajib diisi</p>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Nama Barang <span class="required-star">*</span></label>
                    <input type="text" name="name" class="form-input" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" rows="3" class="form-textarea" placeholder="Masukkan deskripsi barang..."></textarea>
                </div>
                
               <div class="mb-4">
    <label class="form-label">Stok <span class="required-star">*</span></label>
    <input type="number" name="stock" class="form-input" required min="0">
</div>

<div class="mb-4">
    <label class="form-label">Harga Sewa per Hari <span class="required-star">*</span></label>
    <input 
        type="number"
        name="harga_sewa_perhari"
        class="form-input"
        required
        min="0"
        placeholder="Contoh: 15000">
</div>
                
                <div class="mb-4">
                    <label class="form-label">Kondisi</label>
                    <select name="kondisi" class="form-select">
                        <option value="baik">Baik</option>
                        <option value="rusak">Rusak</option>
                        <option value="perbaikan">Perbaikan</option>
                    </select>
                </div>
            </div>
            <div class="custom-modal-footer">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 rounded-lg border border-gray-500 text-gray-400 hover:text-white transition-colors">Batal</button>
                <button type="submit" class="btn-save">➕ Tambah Barang</button>
            </div>
        </form>
    </div>
</div>

<!-- Alert Messages -->
@if (session('success'))
<div id="alert-success" class="fixed top-4 right-4 z-50 flex items-center p-4 rounded-lg bg-green-500/20 border border-green-500/30 shadow-lg animate-slide-in">
    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    <span class="text-green-400">{{ session('success') }}</span>
</div>
@endif

@if (session('error'))
<div id="alert-error" class="fixed top-4 right-4 z-50 flex items-center p-4 rounded-lg bg-red-500/20 border border-red-500/30 shadow-lg animate-slide-in">
    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
    </svg>
    <span class="text-red-400">{{ session('error') }}</span>
</div>
@endif

<script>
    // Preview image for edit modal
    function previewImage(input, previewId, itemId) {
        const preview = document.getElementById(previewId);
        const fileNameSpan = document.getElementById('file-name-' + itemId);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
            
            if (fileNameSpan) {
                fileNameSpan.textContent = '📄 ' + input.files[0].name;
                fileNameSpan.style.color = '#b9a6ff';
            }
        } else {
            if (fileNameSpan) {
                fileNameSpan.textContent = 'Tidak ada file dipilih';
                fileNameSpan.style.color = '#9ca3af';
            }
        }
    }
    
    // Preview image for add modal
    function previewImageAdd(input) {
        const preview = document.getElementById('preview-add');
        const fileNameSpan = document.getElementById('file-name-add');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            
            reader.readAsDataURL(input.files[0]);
            
            if (fileNameSpan) {
                fileNameSpan.textContent = '📄 ' + input.files[0].name;
                fileNameSpan.style.color = '#b9a6ff';
            }
        } else {
            preview.src = "https://via.placeholder.com/120?text=Preview";
            if (fileNameSpan) {
                fileNameSpan.textContent = 'Tidak ada file dipilih';
                fileNameSpan.style.color = '#9ca3af';
            }
        }
    }
    
    // Open Add Modal
    function openAddModal() {
        const modal = document.getElementById('add-modal');
        modal.classList.add('active');
        
        // Reset preview and file name
        const preview = document.getElementById('preview-add');
        const fileNameSpan = document.getElementById('file-name-add');
        const fileInput = document.querySelector('#add-modal .file-input');
        
        if (preview) preview.src = "https://via.placeholder.com/120?text=Preview";
        if (fileNameSpan) fileNameSpan.textContent = 'Tidak ada file dipilih';
        if (fileInput) fileInput.value = '';
    }
    
    // Close Add Modal
    function closeAddModal() {
        const modal = document.getElementById('add-modal');
        modal.classList.remove('active');
    }
    
    // Open Edit Modal
    function openEditModal(id) {
        const modal = document.getElementById('edit-modal-' + id);
        if (modal) {
            modal.classList.add('active');
        }
    }
    
    // Close Edit Modal
    function closeEditModal(id) {
        const modal = document.getElementById('edit-modal-' + id);
        if (modal) {
            modal.classList.remove('active');
        }
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('custom-modal')) {
            event.target.classList.remove('active');
        }
    });
    
    // Search functionality
    const searchInput = document.getElementById('table-search');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(function(row) {
                const name = row.querySelector('td:nth-child(3)');
                if (name && name.textContent.toLowerCase().includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Auto hide alerts
    setTimeout(function() {
        const success = document.getElementById('alert-success');
        const error = document.getElementById('alert-error');
        if (success) success.style.display = 'none';
        if (error) error.style.display = 'none';
    }, 3000);
</script>
@endsection