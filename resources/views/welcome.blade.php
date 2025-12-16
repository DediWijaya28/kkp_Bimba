<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>biMBA AIUEO</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* CSS Tambahan untuk Mobile Menu (Agar tidak perlu plugin JS tambahan) */
        #mobile-menu {
            transition: max-height 0.3s ease-in-out;
            max-height: 0;
            overflow: hidden;
        }
        #mobile-menu.open {
            max-height: 400px; /* Cukup untuk menampung menu */
        }
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

                <nav class="hidden md:flex gap-8 text-sm font-semibold text-black-600">
                    <a href="#hero" class="hover:text-[#0337f5] transition duration-300">Beranda</a>
                    <a href="#tentang" class="hover:text-[#0337f5] transition duration-300">Tentang</a>
                    <a href="#keunggulan" class="hover:text-[#0337f5] transition duration-300">Keunggulan</a>
                    <a href="#jenis-kelas" class="hover:text-[#0337f5] transition duration-300">Jenis Kelas</a>
                    <a href="#kontak" class="hover:text-[#0337f5] transition duration-300">Kontak</a>
                </nav>

                <div class="hidden md:flex gap-3 items-center">
                    @if (Route::has('login'))
                        @auth
                            @if(Auth::user()->role !== 'admin')
                                <a href="{{ route('registration.create') }}" class="bg-[#f50303] text-white px-5 py-2.5 rounded-full font-bold text-sm hover:bg-red-800 transition mr-2">Daftar Siswa</a>
                                <a href="{{ url('/dashboard') }}" class="bg-[#0337f5] text-white px-5 py-2.5 rounded-full font-bold text-sm hover:bg-blue-700 transition">Dashboard</a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="bg-[#0337f5] text-white px-5 py-2.5 rounded-full font-bold text-sm hover:bg-blue-700 transition">Dashboard Admin</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="text-[#1b1b18] font-bold text-sm hover:text-[#0337f5] px-4">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-[#0337f5] text-white px-5 py-2.5 rounded-full font-bold text-sm shadow-md shadow-red-200 hover:bg-red-700 transition transform hover:-translate-y-0.5">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>

                <button id="mobile-menu-btn" class="md:hidden p-2 text-black-600 focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden bg-white border-t border-gray-100">
            <div class="px-6 py-4 flex flex-col gap-4">
                <a href="#hero" class="block font-medium text-black-600 hover:text-[#0337f5]">Beranda</a>
                <a href="#tentang" class="block font-medium text-black-600 hover:text-[#0337f5]">Tentang</a>
                <a href="#keunggulan" class="block font-medium text-black-600 hover:text-[#0337f5]">Keunggulan</a>
                <a href="#jenis-kelas" class="block font-medium text-black-600 hover:text-[#0337f5]">Jenis Kelas</a>
                <a href="#kontak" class="block font-medium text-black-600 hover:text-[#0337f5]">Kontak</a>
                <div class="pt-4 border-t border-gray-100 flex gap-4">
                     @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="flex-1 text-center border border-gray-300 py-2 rounded-lg font-bold text-sm">Masuk</a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="flex-1 text-center bg-[#0337f5] text-white py-2 rounded-lg font-bold text-sm">Daftar</a>
                        @endif
                     @endif
                </div>
            </div>
        </div>
    </header>

    <section id="hero" class="pt-32 pb-20 px-6 max-w-7xl mx-auto flex flex-col-reverse md:flex-row items-center gap-12 scroll-mt-20">
        <div class="flex-1 text-center md:text-left">
            
            <h1 class="text-3xl md:text-6xl font-extrabold mb-6 text-[#1b1b18] leading-tight">
                biMBA AIUEO<br/> Unit <span class="text-[#]"> Klender </span>
            </h1>
            <p class="text-black-500 text-lg mb-8 leading-relaxed max-w-lg mx-auto md:mx-0">
                "Mari Kita Wariskan Minat Belajar Anak Usia Dini Demi Membangun Generasi Pembelajar Mandiri Sepanjang Hayat"
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">

                <a href="#kontak" class="bg-[#0337f5] text-white px-8 py-3.5 rounded-xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 transition">
                    Hubungi Kami
                </a>
                <a href="#tentang" class="bg-white text-[#1b1b18] px-8 py-3.5 rounded-xl font-bold border border-gray-200 hover:bg-gray-50 transition">
                    Pelajari Profil
                </a>
                <a href="{{ route('trial.create') }}" class="bg-yellow-400 text-[#1b1b18] px-8 py-3.5 rounded-xl font-bold shadow-xl shadow-yellow-200 hover:bg-yellow-300 transition flex items-center gap-2">
                    <span>✨</span> Coba Gratis
                </a>
            </div>
        </div>
        <div class="flex-1 w-full flex justify-center">
            <div class="w-full max-w-md aspect-[2/2] bg-gray-100 rounded-3xl overflow-hidden shadow-2xl shadow-gray-100 border border-white relative group">
                <img src="{{ asset('images/logo-bimba.png') }}" 
                     alt="Education" 
                     class="w-full h-full object-contain p-2 transform group-hover:scale-105 transition duration-500">
            </div>
        </div>
    </section>

    <section id="tentang" class="py-12 md:py-20 bg-white scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-2xl md:text-4xl font-bold text-[#1b1b18] mb-4">Visi, Misi & Tujuan Kami</h2>
                <div class="w-24 h-1.5 bg-[#0337f5] mx-auto rounded-full mb-6"></div>
                <!--<p class="text-black-500">Mengenal lebih dekat fondasi pendidikan yang kami bangun sejak tahun 2010.</p>-->
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="bg-[#FDFDFC] p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h3 class="text-xl font-bold text-[#0337f5] mb-4 flex items-center gap-2">
                        Tujuan
                    </h3>
                    <li class="flex items-center gap-3 text-black-600">
                        <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                        Menjadikan Anak Menikmati Proses Belajar Sejak Dini.
                    </li>
                    <br>
                    <li class="flex items-center gap-3 text-black-600">
                        <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                        Membimbing Anak Agar Memiliki Minat Baca dan Belajar Dari Dalam Diri Sendiri.
                    </li>
                    <br>
                    <li class="flex items-center gap-3 text-black-600">
                        <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                        Kata Bimba Menjadi Pola Pikir Masyarakat.
                    </li>
                </div>

                <div>
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-[#1b1b18] mb-3">Visi</h3>
                        <p class="text-lg font-medium text-black-700 italic border-l-4 border-[#0337f5] pl-4">
                            "Membangun Generasi Pembelajar Mandiri Sepanjang Hayat."
                        </p>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-[#1b1b18] mb-3">Misi</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-black-600">
                                <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                                Mensosialisasikan Kata Bimba-AIUEO
                            </li>
                            <br>
                            <li class="flex items-center gap-3 text-black-600">
                                <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                                Mensosialisasikan Kepada Masyarakat Tentang Pentingnya MINAT Baca dan Belajar Pada Anak Sejak Usia Dini.
                            </li>
                            <br>
                            <li class="flex items-center gap-3 text-black-600">
                                <span class="w-6 h-6 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xs font-bold">✓</span>
                                Membimbing dan Mengarahkan Agar Anak Memiliki MINAT Baca dan Belajar.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="keunggulan" class="py-12 md:py-20 bg-gray-50 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-2xl md:text-4xl font-bold text-center mb-16 text-[#1b1b18]">Kenapa Memilih Kami?</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 border border-gray-100">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl mb-6">📃</div>
                    <h3 class="text-xl font-bold">Garansi MBA 372</h3>
                    <p class="text-black-500 text-sm leading-relaxed mb-3">Menjamin bahwa Anak Peserta Didik (minimal usia 3 tahun 0 bulan) akan mampu membaca kata-kata sederhana dalam kurun waktu 72 jam bimbingan didalam kelas .</p>
                    
                    <h3 class="text-xl font-bold">Garansi MBA 399</h3>
                    <p class="text-black-500 text-sm leading-relaxed mb-3">Menjamin bahwa Anak Peserta Didik (minimal usia 3 tahun 0 bulan) akan mampu membaca kata-kata sederhana dalam kurun waktu 99 jam bimbingan didalam kelas .</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 border border-gray-100">
                    <div class="w-14 h-14 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-2xl mb-6">📚</div>
                    <h3 class="text-xl font-bold">Metode Fun Learning</h3>
                    <p class="text-black-500 text-sm leading-relaxed mb-3">Seluruh proses pembelajaran dengan suasana yang 100% menyenangkan untuk Anak.</p>

                    <h3 class="text-xl font-bold">Metode Individual System</h3>
                    <p class="text-black-500 text-sm leading-relaxed mb-3">Setiap Anak belajar sesuai dengan kemampuan dan kemauan masing-masing dan dibimbing agar memiliki kemandirian dalam belajar. </p>

                    <h3 class="text-xl font-bold">Metode Small Step System</h3>
                    <p class="text-black-500 text-sm leading-relaxed mb-3">Modul diberikan secara bertahap sesuai kemampuan Anak sampai Anak mampu ke tingkat selanjutnya. </p>

                
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 border border-gray-100">
                    <div class="w-14 h-14 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center text-2xl mb-6">👨‍👩‍👧‍👦</div>
                    <h3 class="text-xl font-bold">Manfaat Bagi Orang Tua</h3>
                    <p class="text-black-500 text-sm leading-relaxed">• Anak akan mudah diarahkan.</p>
                    <p class="text-black-500 text-sm leading-relaxed">• Anak akan memahami nasihat Orang Tua.</p>
                    <p class="text-black-500 text-sm leading-relaxed">• Keharmonisan dengan Anak meningkat.</p>
                    <p class="text-black-500 text-sm leading-relaxed">• Malas belajar Anak teratasi.</p>
                    <p class="text-black-500 text-sm leading-relaxed">• Dalam jangka panjang menguntungkan secara ekonomi.</p>
                    
                </div>
            </div>
        </div>
    </section>

    <section id="jenis-kelas" class="py-12 md:py-20 bg-white scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-2xl md:text-4xl font-bold text-[#1b1b18]">Program Belajar</h2>
               <!-- <p class="text-black-500 mt-2">Kami membuka pendaftaran untuk jenjang berikut</p> -->
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <a href="{{ route('program.pdi') }}" class="block group relative overflow-hidden rounded-2xl bg-yellow-50 border border-yellow-100 p-8 hover:bg-yellow-100 transition cursor-pointer">
                    <h3 class="text-2xl font-bold text-black-800 mb-2">PDI (Peserta Didik Intensif)</h3>
                    <span class="absolute bottom-0 right-0 p-4 text-6xl opacity-20 transform translate-x-2 translate-y-2 group-hover:scale-110 transition">🧸</span>
                </a>

                <a href="{{ route('program.pds') }}" class="block group relative overflow-hidden rounded-2xl bg-red-50 border border-red-100 p-8 hover:bg-red-100 transition cursor-pointer">
                    <h3 class="text-2xl font-bold text-black-800 mb-2">PDS (Peserta Didik Standar)</h3>
                    <span class="absolute bottom-0 right-0 p-4 text-6xl opacity-20 transform translate-x-2 translate-y-2 group-hover:scale-110 transition">🧸</span>
                </a>

                <a href="{{ route('program.pbm') }}" class="block group relative overflow-hidden rounded-2xl bg-blue-50 border border-blue-100 p-8 hover:bg-blue-100 transition cursor-pointer">
                    <h3 class="text-2xl font-bold text-black-800 mb-2">PBM (Program Belajar Mandiri)</h3>
                    <span class="absolute bottom-0 right-0 p-4 text-6xl opacity-20 transform translate-x-2 translate-y-2 group-hover:scale-110 transition">🧸</span>
                </a>
            </div>
        </div>
    </section>

    <section id="kurikulum" class="py-12 md:py-20 bg-gray-50 scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-2xl md:text-4xl font-bold text-[#1b1b18]">Kurikulum Bimba</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <a href="{{ route('kurikulum.level-1') }}" class="block group relative overflow-hidden rounded-2xl bg-green-50 border border-green-100 p-8 hover:bg-green-100 transition cursor-pointer">
                    <h3 class="text-2xl font-bold text-black-800 mb-2">Level 1</h3>
                    <p class="text-black-600 mb-6 text-sm">Membaca Kata Sederhana</p>
                    <span class="absolute bottom-0 right-0 p-4 text-6xl opacity-20 transform translate-x-2 translate-y-2 group-hover:scale-110 transition">🌱</span>
                </a>

                <a href="{{ route('kurikulum.level-2') }}" class="block group relative overflow-hidden rounded-2xl bg-orange-50 border border-orange-100 p-8 hover:bg-orange-100 transition cursor-pointer">
                    <h3 class="text-2xl font-bold text-black-800 mb-2">Level 2</h3>
                    <p class="text-black-600 mb-6 text-sm">Pengembangan Baca</p>
                    <span class="absolute bottom-0 right-0 p-4 text-6xl opacity-20 transform translate-x-2 translate-y-2 group-hover:scale-110 transition">🌿</span>
                </a>

                <a href="{{ route('kurikulum.level-3') }}" class="block group relative overflow-hidden rounded-2xl bg-purple-50 border border-purple-100 p-8 hover:bg-purple-100 transition cursor-pointer">
                    <h3 class="text-2xl font-bold text-black-800 mb-2">Level 3</h3>
                    <p class="text-black-600 mb-6 text-sm">Pemantapan & Logika</p>
                    <span class="absolute bottom-0 right-0 p-4 text-6xl opacity-20 transform translate-x-2 translate-y-2 group-hover:scale-110 transition">🌳</span>
                </a>

                <a href="{{ route('kurikulum.level-4') }}" class="block group relative overflow-hidden rounded-2xl bg-blue-50 border border-blue-100 p-8 hover:bg-blue-100 transition cursor-pointer">
                    <h3 class="text-2xl font-bold text-black-800 mb-2">Level 4</h3>
                    <p class="text-black-600 mb-6 text-sm">Pemantapan & Logika Lanjutan</p>
                    <span class="absolute bottom-0 right-0 p-4 text-6xl opacity-20 transform translate-x-2 translate-y-2 group-hover:scale-110 transition">🎓</span>
                </a>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-24 bg-[#1b1b18] text-white scroll-mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-16">
                <div>
                    <h2 class="text-2xl md:text-4xl font-bold mb-6">Hubungi Kami</h2>

                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#0337f5] flex items-center justify-center text-xl">📍</div>
                            <div>
                                <h4 class="font-bold text-lg">Alamat Sekolah</h4>
                                <p class="text-black-400 mt-1">Jl. Delima Raya No.99 RT.06 RW.05 Kel.Malaka Sari, Kec.Duren Sawit, Jakarta Timur</p>
                                <div class="mt-4 w-full h-48 rounded-xl overflow-hidden shadow-lg border border-gray-700">
                                    <iframe 
                                        src="https://maps.google.com/maps?q=biMBA+AIUEO+Unit+Klender+Jl.+Delima+Raya+No.99&t=&z=17&ie=UTF8&iwloc=B&output=embed" 
                                        width="100%" 
                                        height="100%" 
                                        style="border:0;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#0337f5] flex items-center justify-center text-xl">📞</div>
                            <div>
                                <h4 class="font-bold text-lg">Layanan Telepon</h4>
                                <p class="text-black-400 mt-1">+6281586304372 (WhatsApp)</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#0337f5] flex items-center justify-center text-xl">📧</div>
                            <div>
                                <h4 class="font-bold text-lg">Email Resmi</h4>
                                <p class="text-black-400 mt-1">bimbaaiueounitklender@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white/5 backdrop-blur-sm p-8 rounded-3xl border border-white/10 flex flex-col justify-center">
                    <h3 class="text-2xl font-bold mb-6">Jam Operasional</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-gray-700 pb-3">
                            <span class="text-black-300">Senin - Jumat</span>
                            <span class="font-mono font-bold">Pukul 08:00 - 16:00 WIB</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-700 pb-3">
                            <span class="text-black-300">Sabtu</span>
                            <span class="font-mono font-bold">Pukul 08:00 - 12:00 WIB</span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-black-300">Minggu</span>
                            <span class="text-[#f50303] font-bold bg-white/10 px-3 py-1 rounded-full text-sm">LIBUR</span>
                        </div>
                    </div>
                    
                    <a href="https://wa.me/+6281586304372" class="mt-8 w-full block bg-[#25D366] hover:bg-green-600 text-white text-center font-bold py-3 rounded-xl transition">
                        Chat WhatsApp Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-8 bg-white text-center border-t border-gray-200">
        <p class="text-black-500 text-sm">
            &copy; {{ date('Y') }} Bimba AIUEO Unit Klender. All rights reserved.
        </p>
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('open');
        });

        // Tutup menu saat link diklik
        menu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                menu.classList.remove('open');
            });
        });
    </script>
</body>
</html>