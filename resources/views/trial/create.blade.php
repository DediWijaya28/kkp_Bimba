@extends('layouts.app')

@section('title', 'Daftar Trial Gratis - Bimba AIUEO Unit Klender')

@section('content')
<div class="max-w-xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
            Coba Gratis 1x Pertemuan
        </h1>
        <p class="mt-4 text-lg text-gray-500">
            Rasakan keseruan belajar di biMBA AIUEO sebelum mendaftar.
        </p>
    </div>

    <div class="bg-white py-8 px-6 shadow rounded-2xl sm:px-10 border border-gray-100">
        <form class="mb-0 space-y-6" action="{{ route('trial.store') }}" method="POST">
            @csrf
            <div>
                <label for="child_name" class="block text-sm font-medium text-gray-700">Nama Anak</label>
                <div class="mt-1">
                    <input id="child_name" name="child_name" type="text" value="{{ old('child_name') }}" required 
                        class="capitalize w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Nama lengkap anak"
                        oninput="this.value = this.value.replace(/\b\w/g, l => l.toUpperCase())">
                </div>
            </div>

            <div>
                <label for="child_age" class="block text-sm font-medium text-gray-700">Usia Anak (Tahun)</label>
                <div class="mt-1">
                    <input id="child_age" name="child_age" type="number" value="{{ old('child_age') }}" required min="2" max="12"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Contoh: 4">
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <label for="parent_name" class="block text-sm font-medium text-gray-700">Nama Orang Tua</label>
                <div class="mt-1">
                    <input id="parent_name" name="parent_name" type="text" value="{{ old('parent_name') }}" required 
                        class="capitalize w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Nama Ayah/Ibu"
                        oninput="this.value = this.value.replace(/\b\w/g, l => l.toUpperCase())">
                </div>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                <div class="mt-1">
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required 
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="08xxxxxxxxxx">
                    <p class="mt-1 text-xs text-gray-500">Admin kami akan menghubungi Anda untuk jadwal trial.</p>
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Buat Akun</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required 
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="nama@email.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" required 
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="********">
                            </div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <div class="mt-1">
                                <input id="password_confirmation" name="password_confirmation" type="password" required 
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="********">
                            </div>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-500 md:col-span-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition">
                    Daftar Trial Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
