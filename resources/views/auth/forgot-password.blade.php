@extends('layouts.app')

@section('title', 'Lupa Password - Bimba AIUEO Unit Klender')

@section('content')
<div class="flex justify-center items-center min-h-[60vh]">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Lupa Password?</h2>
                <p class="text-gray-500 mb-8">Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset password.</p>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" required autofocus
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 outline-none"
                            placeholder="nama@email.com" value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Kirim Link Reset Password
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Kembali ke Halaman Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
