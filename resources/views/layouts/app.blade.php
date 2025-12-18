<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'biMBA AIUEO')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bimba1.png') }}?v=2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        .glass-dark {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen text-gray-800">
    <nav class="fixed w-full z-50 glass shadow-sm" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-3">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo-bimba1.png') }}?v=2" 
                             alt="Logo" 
                             class="h-14 w-auto object-contain">
                        <span class="font-bold text-xl text-[#1b1b18] leading-none hidden sm:block" style="font-family: 'Comic Sans MS', 'Comic Sans', cursive;">
                            <span class="text-[#0337f5]">b</span><span class="text-[#0337f5]">i</span><span class="text-[#f50303]">M</span><span class="text-[#0337f5]">B</span><span class="text-[#0337f5]">A</span>
                            <span class="text-[#f50303]">A</span><span class="text-[#e9f503]">I</span><span class="text-[#0337f5]">U</span><span class="text-[#0f7002]">E</span><span class="text-[#ed912f]">O</span>
                        </span>
                    </a>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <span class="px-2 py-0.5 bg-red-100 text-red-800 text-[10px] sm:text-xs font-bold rounded-full border border-red-200">ADMIN</span>
                        @endif
                    @endauth
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">Dashboard</a>
                            <a href="{{ route('admin.trials.index') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">Data Trial</a>
                            <a href="{{ route('admin.classes.index') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">Manajemen Kelas</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">Dashboard</a>
                        @endif

                        <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                            <span class="text-sm text-gray-600 font-medium">Hi, {{ Auth::user()->name }}</span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 transition">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 rounded-full bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Daftar Sekarang</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden">
                    <button @click="open = !open" class="p-2 rounded-md text-gray-600 hover:text-indigo-600 focus:outline-none transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="open" x-cloak 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden glass border-t border-gray-100 absolute w-full left-0 z-40">
            <div class="px-4 py-4 space-y-3 shadow-lg">
                @auth
                    <div class="pb-3 border-b border-gray-100 mb-3">
                        <p class="text-sm text-gray-500">Masuk sebagai</p>
                        <p class="font-bold text-gray-800">{{ Auth::user()->name }}</p>
                    </div>

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition">Dashboard</a>
                        <a href="{{ route('admin.trials.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition">Data Trial</a>
                        <a href="{{ route('admin.classes.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition">Manajemen Kelas</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition">Dashboard</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="pt-2">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-base font-bold text-red-500 hover:bg-red-50 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold hover:bg-gray-50 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-md transition">Daftar Sekarang</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="pt-24 pb-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700 border border-green-200 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-700 border border-red-200 shadow-sm">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Bimba AIUEO Unit Klender. All rights reserved.
        </div>
    </footer>
    <script>
        // Fallback vanilla JS to wire select-all and per-row checkboxes
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('bulk-delete-form');
            if (!form) return;

            const header = document.getElementById('select-all-header');
            const selectedCountEl = document.getElementById('selected-count');
            const hiddenSelectAll = document.getElementById('select-all-hidden');

            function getBoxes() {
                return Array.from(form.querySelectorAll('.student-checkbox'));
            }

            function updateStateFromBoxes() {
                const boxes = getBoxes();
                const checked = boxes.filter(b => b.checked);
                if (selectedCountEl) selectedCountEl.textContent = checked.length;
                if (header) header.checked = boxes.length > 0 && boxes.every(b => b.checked);
                // keep hidden select_all unless dataset flag set
                if (form.dataset.selectAllAcross !== '1') {
                    if (hiddenSelectAll) hiddenSelectAll.value = '0';
                } else {
                    if (hiddenSelectAll) hiddenSelectAll.value = '1';
                }
            }

            // Header toggles visible checkboxes
            if (header) {
                header.addEventListener('change', function () {
                    const boxes = getBoxes();
                    boxes.forEach(b => b.checked = header.checked);
                    // when header manually unchecked, clear selectAllAcross flag
                    if (!header.checked) form.dataset.selectAllAcross = '0';
                    updateStateFromBoxes();
                });
            }

            // Wire individual checkboxes
            function wireBoxes() {
                const boxes = getBoxes();
                boxes.forEach(b => {
                    b.removeEventListener('change', updateStateFromBoxes);
                    b.addEventListener('change', function () {
                        // if user manually unchecks a box, clear selectAllAcross
                        if (!b.checked) form.dataset.selectAllAcross = '0';
                        updateStateFromBoxes();
                    });
                });
            }

            // initial wire & state
            wireBoxes();
            updateStateFromBoxes();

            // If rows may be replaced dynamically, observe for changes and re-wire
            const observer = new MutationObserver(function () {
                wireBoxes();
                updateStateFromBoxes();
            });
            observer.observe(form, { childList: true, subtree: true });
        });
    </script>
    @yield('scripts')
</body>
</html>
