<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Lentora')</title>
    
    <link rel="icon" type="image/png" href="{{ asset('assets/img/Avatar.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    
    <style>
        /* Semua style dari pinjamBarang.blade.php */
        :root {
            --primary-color: #b9a6ff;
            --primary-dark: #9a87e6;
            --primary-light: #d4c4ff;
            --secondary-color: #1a1a2e;
            --text-light: #ffffff;
            --text-soft: #e0e0e0;
            --border-dark: rgba(185, 166, 255, 0.2);
        }
        
        body {
            background-color: var(--secondary-color);
            font-family: system-ui, -apple-system, sans-serif;
        }
        
        /* Sidebar styling */
        #logo-sidebar {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #16213e 100%);
            border-right: 1px solid rgba(185, 166, 255, 0.1);
        }
        
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            color: #9ca3af;
            border-radius: 1rem;
            transition: all 0.3s ease;
        }
        
        .sidebar-item:hover, .sidebar-item.active {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .sidebar-item svg {
            width: 1.25rem;
            height: 1.25rem;
            color: var(--primary-color);
        }
        
        .sidebar-item:hover svg, .sidebar-item.active svg {
            color: white;
        }
        
        .logout-item:hover {
            background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
        }
        
        .camera-logo {
            background: var(--primary-color);
            transition: all 0.3s ease;
        }

        .camera-logo:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(185, 166, 255, 0.5);
        }

        .logo-text {
            color: var(--text-light) !important;
        }
        
        .header-gradient {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #16213e 50%, #0f3460 100%);
            position: relative;
            overflow: hidden;
        }
        
        .content-card, .form-container {
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
        
        .table-container thead tr {
            background: linear-gradient(90deg, rgba(185, 166, 255, 0.15) 0%, rgba(154, 135, 230, 0.1) 100%);
        }
        
        .btn-primary {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: var(--secondary-color);
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(185, 166, 255, 0.3);
        }
        
        .form-control {
            background: rgba(22, 33, 62, 0.8);
            border: 1px solid var(--border-dark);
            color: var(--text-soft);
            border-radius: 0.5rem;
            padding: 0.75rem;
            width: 100%;
        }
        
        .form-group label {
            color: var(--primary-light);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }
        
        .status-badge.pending { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
        .status-badge.approved { background: rgba(59, 130, 246, 0.2); color: #60a5fa; }
        .status-badge.borrowed { background: rgba(34, 197, 94, 0.2); color: #4ade80; }
        .status-badge.returned { background: rgba(107, 114, 128, 0.2); color: #9ca3af; }
        .status-badge.rejected { background: rgba(239, 68, 68, 0.2); color: #f87171; }
        
        .alert-success, .alert-error {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 1rem;
            border-radius: 0.75rem;
            backdrop-filter: blur(10px);
            animation: slideIn 0.3s ease;
        }
        
        .alert-success {
            background: rgba(26, 26, 46, 0.95);
            border: 1px solid var(--primary-color);
            color: var(--primary-light);
        }
        
        .alert-error {
            background: rgba(26, 26, 46, 0.95);
            border: 1px solid #ef4444;
            color: #fca5a5;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-[#1a1a2e]">
    <!-- Button toggle sidebar mobile -->
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"/>
        </svg>
    </button>

    <!-- Sidebar -->
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform bg-[#161625] -translate-x-full sm:translate-x-0 shadow-xl"
        aria-label="Sidebar">
        <div class="h-full flex flex-col px-4 py-12 overflow-y-auto bg-[#161625]">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center ps-2.5 mb-10 group">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center camera-logo group-hover:shadow-lg transition-all duration-300">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M23 19C23 19.5304 22.7893 20.0391 22.4142 20.4142C22.0391 20.7893 21.5304 21 21 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V8C1 7.46957 1.21071 6.96086 1.58579 6.58579C1.96086 6.21071 2.46957 6 3 6H7L9 3H15L17 6H21C21.5304 6 22.0391 6.21071 22.4142 6.58579C22.7893 6.96086 23 7.46957 23 8V19Z" stroke="white" stroke-width="2"/>
                        <circle cx="12" cy="13" r="4" stroke="white" stroke-width="2"/>
                        <circle cx="18" cy="10" r="1" fill="white"/>
                    </svg>
                </div>
                <span class="self-center text-xl font-semibold ml-3 logo-text">peminjaman kamera</span>
            </a>
            
            <!-- Menu berdasarkan role -->
            @if (auth()->user()->role === 'admin')
                <ul class="space-y-2 font-medium">
                    <li><a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 22 21"><path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/><path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/></svg><span class="ms-3">Dashboard</span></a></li>
                    <li><a href="{{ route('items') }}" class="sidebar-item {{ request()->routeIs('items*') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 18 18"><path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Z"/></svg><span class="ms-3">Inventaris</span></a></li>
                    <li><a href="{{ route('pinjamBarang') }}" class="sidebar-item {{ request()->routeIs('pinjamBarang*') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/></svg><span class="ms-3">Peminjaman</span></a></li>
                    <li><a href="{{ route('transactions') }}" class="sidebar-item {{ request()->routeIs('transactions*') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 10l-4 4-4-4m4 4V2"/></svg><span class="ms-3">Transaksi</span></a></li>
                    <li><a href="{{ route('users') }}" class="sidebar-item {{ request()->routeIs('users*') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 18"><path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/></svg><span class="ms-3">List User</span></a></li>
                    <li><a href="{{ route('logs') }}" class="sidebar-item {{ request()->routeIs('logs*') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512"><path d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z"/></svg><span class="ms-3">Log Aktivitas</span></a></li>
                    <li><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-item w-full text-left logout-item"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg><span class="ms-3">Logout</span></button></form></li>
                </ul>
            @elseif (auth()->user()->role === 'petugas')
                <ul class="space-y-2 font-medium">
                    <li><a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 22 21"><path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/><path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/></svg><span class="ms-3">Dashboard</span></a></li>
                    <li><a href="{{ route('items') }}" class="sidebar-item {{ request()->routeIs('items*') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 18 18"><path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Z"/></svg><span class="ms-3">Inventaris</span></a></li>
                    <li><a href="{{ route('pinjamBarang') }}" class="sidebar-item {{ request()->routeIs('pinjamBarang*') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/></svg><span class="ms-3">Peminjaman</span></a></li>
                    <li><a href="{{ route('transactions') }}" class="sidebar-item {{ request()->routeIs('transactions*') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 10l-4 4-4-4m4 4V2"/></svg><span class="ms-3">Transaksi</span></a></li>
                    <li><a href="{{ route('logs') }}" class="sidebar-item {{ request()->routeIs('logs*') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512"><path d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z"/></svg><span class="ms-3">Log Aktivitas</span></a></li>
                    <li class="pt-4 mt-4 border-t border-gray-700"><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-item w-full text-left logout-item"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg><span class="ms-3">Logout</span></button></form></li>
                </ul>
            @elseif (auth()->user()->role === 'user')
                <ul class="space-y-2 font-medium">
                    <li><a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 22 21"><path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/><path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/></svg><span class="ms-3">Dashboard</span></a></li>
                    <li><a href="{{ route('pinjamBarang') }}" class="sidebar-item {{ request()->routeIs('pinjamBarang*') ? 'active' : '' }}"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/></svg><span class="ms-3">Peminjaman</span></a></li>
                    <li><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-item w-full text-left logout-item"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/></svg><span class="ms-3">Logout</span></button></form></li>
                </ul>
            @endif
        </div>
    </aside>

    <!-- Main Content -->
    <div class="sm:ml-64 bg-[#1a1a2e] min-h-screen pb-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    @stack('scripts')
</body>
</html>