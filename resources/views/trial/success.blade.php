@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - Bimba AIUEO Unit Klender')

@section('content')
<div class="flex justify-center items-center min-h-[60vh]">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 p-8 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Terima Kasih!</h2>
        <p class="text-gray-600 mb-8">
            Permintaan trial gratis Anda telah kami terima. Admin kami akan segera menghubungi Anda melalui WhatsApp untuk menjadwalkan waktu trial.
        </p>

        <div class="bg-indigo-50 rounded-xl p-6 mb-8">
            <h3 class="font-bold text-indigo-900 mb-2">Sudah yakin ingin mendaftar?</h3>
            <p class="text-indigo-700 text-sm mb-4">Anda bisa langsung mengisi formulir pendaftaran lengkap jika ingin segera bergabung.</p>
            <a href="{{ route('register') }}" class="block w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-700 transition">
                Lanjut ke Pendaftaran Lengkap
            </a>
        </div>

        <a href="{{ url('/') }}" class="text-gray-500 hover:text-gray-900 font-medium">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
