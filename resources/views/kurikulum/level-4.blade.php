<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kurikulum Level 4 - PPDB biMBA AIUEO</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    <main class="pt-32 pb-20 px-6 max-w-4xl mx-auto">
        <div class="bg-purple-50 border border-purple-100 rounded-3xl p-8 md:p-12 mb-12">
            <div class="flex items-center gap-4 mb-6">
                <span class="text-6xl">🌳</span>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900">Kurikulum Level 4</h1>
            </div>
            <p class="text-xl text-gray-700 leading-relaxed">
                Level pemantapan kemampuan membaca dan menulis serta pengenalan logika matematika sederhana.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-16">
            <div>
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-sm">01</span>
                    Materi Pembelajaran
                </h2>
                <ul class="space-y-4 text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Membaca cerita pendek.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Menulis kata dan kalimat.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Logika matematika dasar.
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-sm">02</span>
                    Tujuan
                </h2>
                <ul class="space-y-4 text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Anak terampil membaca dan menulis.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Anak siap masuk Sekolah Dasar (SD).
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center shadow-sm">
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
