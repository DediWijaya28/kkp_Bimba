<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PDI (Peserta Didik Intensif)</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bimba1.png') }}?v=2">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] font-sans antialiased">
    
    <header class="fixed w-full bg-white/95 backdrop-blur-md shadow-sm z-50 top-0 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-bimba1.png') }}?v=2" 
                         alt="Logo" 
                         class="h-18 w-auto object-contain">
                    <span class="font-bold text-2xl text-[#1b1b18]"  style="font-family: 'Comic Sans MS', 'Comic Sans', cursive;">
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
        <div class="bg-yellow-50 border border-yellow-100 rounded-3xl p-8 md:p-12 mb-12">
            <div class="flex items-center gap-4 mb-6">
                <span class="text-6xl">🧸</span>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900">PDI (Peserta Didik Intensif)</h1>
            </div>
            <p class="text-xl text-gray-700 leading-relaxed">
                Dikhususkan untuk anak usia 3-7 tahun yang belum bersekolah atau belum memiliki kegiatan rutin.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-16">
            <div>
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center text-sm">01</span>
                    Detail Kelas
                </h2>
                <ul class="space-y-4 text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        3 kali dalam seminggu, pada hari Senin, Rabu, dan Jumat.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Durasi belajar 45 menit.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Setiap 1 guru mengajar 3 murid.
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center text-sm">02</span>
                    Pilihan Jam Belajar:
                </h2>
                <ul class="space-y-4 text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Pukul 08.00 - 08.45 WIB.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Pukul 08.45 - 09.30 WIB.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Pukul 09.30 - 10.15 WIB.
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        Pukul 10.15 - 11.00 WIB.
                    </li>
                </ul>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center text-sm">03</span>
                    Biaya Kelas
                </h2>
                <ul class="space-y-4 text-gray-600">
                    <li class="flex items-start gap-3">
                        <span class="text-green-500 font-bold">✓</span>
                        SPP Rp500.000/bulan.
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center shadow-sm">
            <h3 class="text-2xl font-bold mb-4">Siap Mendaftarkan Putra/Putri Anda?</h3>
            <p class="text-gray-600 mb-8">Dengan kasih sayang yang tulus kami wujudkan impian Orang Tua dengan menjadikan Anak-anak kita memiliki 
                minat dan mampu baca sehingga menjadi pribadi yang kreatif, inovatif, dan mandiri.</p>
            <div class="flex justify-center gap-4">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-[#0337f5] text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition">
                        Daftar Sekarang
                    </a>
                @endif
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
