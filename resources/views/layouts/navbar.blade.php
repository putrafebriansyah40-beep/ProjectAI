<nav class="sticky top-0 z-50 backdrop-blur-md bg-white/70 dark:bg-bg-dark/80 border-b border-border-light dark:border-border-dark transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo / Brand -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <span class="text-xl font-bold tracking-wider bg-gradient-to-r from-primary-blue to-accent-cyan bg-clip-text text-transparent">
                        Bug Priority Analyzer
                    </span>
                </a>
            </div>

            <!-- Navigation Links (Desktop) -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ url('/') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-all {{ Request::is('/') ? 'text-primary-blue border-b-2 border-primary-blue rounded-none' : 'text-slate-600 dark:text-slate-300 hover:text-primary-blue hover:dark:text-accent-cyan' }}">
                    Home
                </a>
                <a href="{{ url('/materi') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-all {{ Request::is('materi*') ? 'text-primary-blue border-b-2 border-primary-blue rounded-none' : 'text-slate-600 dark:text-slate-300 hover:text-primary-blue hover:dark:text-accent-cyan' }}">
                    Materi Fuzzy
                </a>
                <a href="{{ url('/simulasi') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-all {{ Request::is('simulasi*') ? 'text-primary-blue border-b-2 border-primary-blue rounded-none' : 'text-slate-600 dark:text-slate-300 hover:text-primary-blue hover:dark:text-accent-cyan' }}">
                    Simulasi
                </a>
                <a href="{{ url('/perbandingan') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-all {{ Request::is('perbandingan*') ? 'text-primary-blue border-b-2 border-primary-blue rounded-none' : 'text-slate-600 dark:text-slate-300 hover:text-primary-blue hover:dark:text-accent-cyan' }}">
                    Perbandingan Metode
                </a>
                <a href="{{ url('/history') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-all {{ Request::is('history*') ? 'text-primary-blue border-b-2 border-primary-blue rounded-none' : 'text-slate-600 dark:text-slate-300 hover:text-primary-blue hover:dark:text-accent-cyan' }}">
                    Riwayat
                </a>
                <a href="{{ url('/tentang') }}" class="px-3 py-2 rounded-md text-sm font-medium transition-all {{ Request::is('tentang*') ? 'text-primary-blue border-b-2 border-primary-blue rounded-none' : 'text-slate-600 dark:text-slate-300 hover:text-primary-blue hover:dark:text-accent-cyan' }}">
                    Tentang
                </a>
            </div>

            <!-- Theme Toggle and Mobile Menu Button -->
            <div class="flex items-center gap-4">
                <!-- Theme Toggle Button -->
                <button id="theme-toggle" type="button" class="text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 rounded-lg text-sm p-2.5 transition-all" aria-label="Toggle dark mode">
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464a1 1 0 10-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Mobile Menu Button (Hamburger) -->
                <button id="mobile-menu-btn" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-blue transition-all" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon Hamburger -->
                    <svg id="hamburger-icon" class="block h-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Icon Close -->
                    <svg id="close-icon" class="hidden h-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu, show/hide based on menu state. -->
    <div id="mobile-menu" class="hidden md:hidden border-b border-border-light dark:border-border-dark bg-white dark:bg-bg-dark/95 transition-all">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ Request::is('/') ? 'bg-primary-blue/10 text-primary-blue' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Home
            </a>
            <a href="{{ url('/materi') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ Request::is('materi*') ? 'bg-primary-blue/10 text-primary-blue' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Materi Fuzzy
            </a>
            <a href="{{ url('/simulasi') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ Request::is('simulasi*') ? 'bg-primary-blue/10 text-primary-blue' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Simulasi
            </a>
            <a href="{{ url('/perbandingan') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ Request::is('perbandingan*') ? 'bg-primary-blue/10 text-primary-blue' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Perbandingan Metode
            </a>
            <a href="{{ url('/history') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ Request::is('history*') ? 'bg-primary-blue/10 text-primary-blue' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Riwayat
            </a>
            <a href="{{ url('/tentang') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ Request::is('tentang*') ? 'bg-primary-blue/10 text-primary-blue' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Tentang
            </a>
        </div>
    </div>
</nav>

<script>
    // Theme Toggle Logic
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Ubah icon tombol berdasarkan tema saat ini
    if (localStorage.getItem('theme') === 'light' || (!('theme' in localStorage) && !window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }

    const themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn.addEventListener('click', function() {
        // Toggle icon
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // Toggle tema
        if (localStorage.getItem('theme')) {
            if (localStorage.getItem('theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    });

    // Mobile Menu Toggle Logic
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');

    mobileMenuBtn.addEventListener('click', () => {
        const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
        mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
        mobileMenu.classList.toggle('hidden');
        hamburgerIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });
</script>
