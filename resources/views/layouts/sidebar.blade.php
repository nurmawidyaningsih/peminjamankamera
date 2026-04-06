<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
    type="button"
    class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-9 h-9" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform bg-[#161625] -translate-x-full sm:translate-x-0 shadow-xl"
    aria-label="Sidebar">
    <div class="h-full flex flex-col justify-normal px-4 py-12 overflow-y-auto bg-[#161625]">
        <!-- Logo dengan Kamera -->
        <a href="{{ route('dashboard') }}" class="flex items-center ps-2.5 mb-10 group">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center camera-logo group-hover:shadow-lg transition-all duration-300">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23 19C23 19.5304 22.7893 20.0391 22.4142 20.4142C22.0391 20.7893 21.5304 21 21 21H3C2.46957 21 1.96086 20.7893 1.58579 20.4142C1.21071 20.0391 1 19.5304 1 19V8C1 7.46957 1.21071 6.96086 1.58579 6.58579C1.96086 6.21071 2.46957 6 3 6H7L9 3H15L17 6H21C21.5304 6 22.0391 6.21071 22.4142 6.58579C22.7893 6.96086 23 7.46957 23 8V19Z" 
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="13" r="4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="18" cy="10" r="1" fill="white"/>
                </svg>
            </div>
            <span class="self-center text-xl font-semibold whitespace-nowrap ml-3" style="color: var(--text-light);">peminjaman kamera</span>
        </a>
        
        @if (auth()->user()->role === 'admin')
            <ul class="space-y-2 py-4 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-3 {{ request()->routeIs('dashboard') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('items') }}" class="flex items-center p-3 {{ request()->routeIs('items*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('items*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                            <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Inventaris</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pinjamBarang') }}" class="flex items-center p-3 {{ request()->routeIs('pinjamBarang*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('pinjamBarang*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Peminjaman</span>
                    </a>
                </li>
                <!-- ========== MENU TRANSAKSI UNTUK ADMIN ========== -->
                <li>
                    <a href="{{ route('transactions') }}" class="flex items-center p-3 {{ request()->routeIs('transactions*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('transactions*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 10l-4 4-4-4m4 4V2"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Transaksi</span>
                    </a>
                </li>
                <!-- ========== END MENU TRANSAKSI ========== -->
                <li>
                    <a href="{{ route('users') }}" class="flex items-center p-3 {{ request()->routeIs('users*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('users*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                            <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">List User</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logs') }}" class="flex items-center p-3 {{ request()->routeIs('logs*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('logs*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Log Aktivitas</span>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="flex items-center p-3 text-gray-400 hover:text-white rounded-2xl hover:bg-red-500 group transition-all duration-300">
                        @csrf
                        <svg class="flex-shrink-0 w-5 h-5 text-primary transition duration-75 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                        </svg>
                        <button type="submit" class="flex-1 ms-3 text-left whitespace-nowrap">Logout</button>
                    </form>
                </li>
            </ul>
        
        @elseif (auth()->user()->role === 'petugas')
            <ul class="space-y-2 py-4 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-3 {{ request()->routeIs('dashboard') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('items') }}" class="flex items-center p-3 {{ request()->routeIs('items*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('items*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                            <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Inventaris</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pinjamBarang') }}" class="flex items-center p-3 {{ request()->routeIs('pinjamBarang*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('pinjamBarang*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Peminjaman</span>
                    </a>
                </li>
                <!-- ========== MENU TRANSAKSI UNTUK PETUGAS ========== -->
                <li>
                    <a href="{{ route('transactions') }}" class="flex items-center p-3 {{ request()->routeIs('transactions*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('transactions*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 10l-4 4-4-4m4 4V2"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Transaksi</span>
                    </a>
                </li>
                <!-- ========== END MENU TRANSAKSI ========== -->
                <li>
                    <a href="{{ route('logs') }}" class="flex items-center p-3 {{ request()->routeIs('logs*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('logs*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Log Aktivitas</span>
                    </a>
                </li>
                <li class="pt-4 mt-4 border-t border-gray-700">
                    <form method="POST" action="{{ route('logout') }}" class="flex items-center p-3 text-gray-400 hover:text-white rounded-2xl hover:bg-red-500 group transition-all duration-300">
                        @csrf
                        <svg class="flex-shrink-0 w-5 h-5 text-primary transition duration-75 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                        </svg>
                        <button type="submit" class="flex-1 ms-3 text-left whitespace-nowrap">Logout</button>
                    </form>
                </li>
            </ul>
        
        @elseif (auth()->user()->role === 'user')
            <ul class="space-y-2 py-4 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-3 {{ request()->routeIs('dashboard') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="w-5 h-5 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pinjamBarang') }}" class="flex items-center p-3 {{ request()->routeIs('pinjamBarang*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('pinjamBarang*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Peminjaman</span>
                    </a>
                </li>
                <!-- ========== MENU TRANSAKSI UNTUK USER (Lihat transaksi sendiri) ========== -->
                <li>
                    <a href="{{ route('transactions') }}" class="flex items-center p-3 {{ request()->routeIs('transactions*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('transactions*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M16 10l-4 4-4-4m4 4V2"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Riwayat Transaksi</span>
                    </a>
                </li>
                <!-- ========== END MENU TRANSAKSI ========== -->
                <li>
                    <a href="{{ route('logs') }}" class="flex items-center p-3 {{ request()->routeIs('logs*') ? 'bg-primary text-white' : 'text-gray-400 hover:text-white hover:bg-primary' }} rounded-2xl group transition-all duration-300">
                        <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ request()->routeIs('logs*') ? 'text-white' : 'text-primary group-hover:text-white' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M64 480H448c35.3 0 64-28.7 64-64V160c0-35.3-28.7-64-64-64H288c-10.1 0-19.6-4.7-25.6-12.8L243.2 57.6C231.1 41.5 212.1 32 192 32H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Log Aktivitas</span>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="flex items-center p-3 text-gray-400 hover:text-white rounded-2xl hover:bg-red-500 group transition-all duration-300">
                        @csrf
                        <svg class="flex-shrink-0 w-5 h-5 text-primary transition duration-75 group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                        </svg>
                        <button type="submit" class="flex-1 ms-3 text-left whitespace-nowrap">Logout</button>
                    </form>
                </li>
            </ul>
        @endif
    </div>
</aside>