<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelas Level 1</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] font-sans antialiased">
    
    <header class="fixed w-full bg-white/95 backdrop-blur-md shadow-sm z-50 top-0 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                     <img src="{{ asset('images/logo-bimba1.png') }}" 
                         alt="Logo" 
                         class="h-16 w-auto object-contain">
                    <span class="font-bold text-xl text-[#1b1b18]"  style="font-family: 'Comic Sans MS', 'Comic Sans', cursive;">
                        <span class="text-[#0337f5]">b</span><span class="text-[#0337f5]">i</span><span class="text-[#f50303]">M</span><span class="text-[#0337f5]">B</span><span class="text-[#0337f5]">A</span>
                        <span class="text-[#f50303]">A</span><span class="text-[#e9f503]">I</span><span class="text-[#0337f5]">U</span><span class="text-[#0f7002]">E</span><span class="text-[#ed912f]">O</span>
                    </span>
                </div>
                <a href="{{ url('/') }}" class="text-sm font-semibold text-gray-600 hover:text-[#0337f5] transition">
                    &larr; Kembali ke Beranda
                </a>
            </div>
        </div>
    </header>

    <main class="pt-32 pb-20 px-6 max-w-4xl mx-auto" x-data="{ activeAccordion: '1A' }">
        <!-- Header Section -->
        <div class="text-center mb-10">
            <h1 class="text-5xl font-bold text-black mb-6">Level 1</h1>
            <div class="text-left max-w-3xl mx-auto space-y-2">
                <div class="flex items-start gap-2">
                    <span class="text-red-500 text-xl transform -rotate-45">📌</span>
                    <p class="font-bold text-black text-lg">Bertujuan membangun pondasi dalam belajar membaca dengan mengenalkan 100 kata sederhana</p>
                </div>
                <div class="flex items-start gap-2">
                    <span class="text-red-500 text-xl transform -rotate-45">📌</span>
                    <p class="font-bold text-black text-lg">Berfokus pada pengembangan minat dan kemampuan baca anak</p>
                </div>
            </div>
        </div>

        <!-- Accordions -->
        <div class="space-y-4">
            <!-- Modul Baca 1A -->
            <div class="overflow-hidden rounded-2xl">
                <button 
                    @click="activeAccordion = activeAccordion === '1A' ? null : '1A'"
                    class="w-full bg-[#67E8F9] hover:bg-[#22D3EE] transition-colors p-4 flex justify-between items-center text-left">
                    <span class="font-bold text-xl text-black">MODUL BACA 1A</span>
                    <svg 
                        class="w-6 h-6 transform transition-transform duration-200" 
                        :class="activeAccordion === '1A' ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div 
                    x-show="activeAccordion === '1A'" 
                    x-collapse
                    class="bg-[#be3a5f] text-white p-8 relative">
                    <!-- Decorative edges roughly mimicking the wavy line in image if possible, but standard box is safer for now. -->
                    <div class="flex flex-col md:flex-row gap-6 items-center">
                        <div class="flex-1 space-y-6">
                            <ul class="space-y-6">
                                <li class="flex items-start gap-3">
                                    <span class="mt-1.5 w-2 h-2 bg-white rounded-full flex-shrink-0"></span>
                                    <span class="font-bold leading-relaxed">
                                        Bertujuan mengenalkan huruf B, D, G, K, M, P, S, Y dan cara membaca kata bersuku kata kembar seperti kata: BOBO, BIBI, DADA, DEDE, GIGI, KUKU, MAMA, MIMI, PAPA, PIPI, SUSU, dan YOYO.
                                    </span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="mt-1.5 w-2 h-2 bg-white rounded-full flex-shrink-0"></span>
                                    <span class="font-bold leading-relaxed">
                                        Diberikan apabila anak sudah mengenal huruf A, I, U, E, O dan mampu melafalkan huruf B, D, G, K, M, P, S, Y.
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <!-- Placeholder for the image in the screenshot -->
                        <div class="w-full md:w-1/3 bg-white/20 rounded-lg p-2 backdrop-blur-sm">
                            <img src="{{ asset('images/modul-baca-1a.jpg') }}" 
                                 alt="Modul Baca 1A" 
                                 class="w-full h-full object-contain rounded bg-white">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modul Baca 1B -->
            <div class="overflow-hidden rounded-2xl">
                <button 
                    @click="activeAccordion = activeAccordion === '1B' ? null : '1B'"
                    class="w-full bg-[#67E8F9] hover:bg-[#22D3EE] transition-colors p-4 flex justify-between items-center text-left">
                    <span class="font-bold text-xl text-black">MODUL BACA 1B</span>
                    <svg 
                        class="w-6 h-6 transform transition-transform duration-200" 
                        :class="activeAccordion === '1B' ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div 
                    x-show="activeAccordion === '1B'" 
                    x-collapse
                    class="bg-[#be3a5f] text-white p-8">
                    <div class="flex flex-col md:flex-row gap-6">
                         <div class="flex-1">
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <span class="mt-1.5 w-2 h-2 bg-white rounded-full flex-shrink-0"></span>
                                    <span class="font-bold">
                                        Pengenalan huruf J, L, N, T, R, C dan kata-kata sederhana lainnya dengan metode yang menyenangkan.
                                    </span>
                                </li>
                            </ul>
                         </div>
                    </div>
                </div>
            </div>

            <!-- Modul Baca 1C -->
            <div class="overflow-hidden rounded-2xl">
                <button 
                    @click="activeAccordion = activeAccordion === '1C' ? null : '1C'"
                    class="w-full bg-[#67E8F9] hover:bg-[#22D3EE] transition-colors p-4 flex justify-between items-center text-left">
                    <span class="font-bold text-xl text-black">MODUL BACA 1C</span>
                    <svg 
                        class="w-6 h-6 transform transition-transform duration-200" 
                        :class="activeAccordion === '1C' ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div 
                    x-show="activeAccordion === '1C'" 
                    x-collapse
                    class="bg-[#be3a5f] text-white p-8">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-1">
                           <ul class="space-y-4">
                               <li class="flex items-start gap-3">
                                   <span class="mt-1.5 w-2 h-2 bg-white rounded-full flex-shrink-0"></span>
                                   <span class="font-bold">
                                       Lanjutan pengenalan susunan huruf yang lebih kompleks untuk mempersiapkan kemampuan membaca kalimat.
                                   </span>
                               </li>
                           </ul>
                        </div>
                   </div>
                </div>
            </div>
        </div>

        <div class="mt-16 bg-white border border-gray-200 rounded-2xl p-8 text-center shadow-sm">
            <h3 class="text-2xl font-bold mb-4">Ingin Tahu Lebih Lanjut?</h3>
            <p class="text-gray-600 mb-8">Hubungi kami untuk konsultasi mengenai perkembangan buah hati Anda.</p>
            <div class="flex justify-center gap-4">
                <a href="https://wa.me/+6281586304372" class="bg-[#25D366] text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-green-200 hover:bg-green-600 transition">
                    Konsultasi via WA
                </a>
            </div>
        </div>
    </main>

    <footer class="py-8 bg-white text-center border-t border-gray-200">
        <p class="text-gray-500 text-sm">
            &copy; {{ date('Y') }} Bimba AIUEO Unit Klender. All rights reserved.
        </p>
    </footer>
</body>
</html>
