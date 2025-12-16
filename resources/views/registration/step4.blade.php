@extends('layouts.app')

@section('title', 'Langkah 2: Pilih Kelas - BIMBA AIUEO Unit Klender')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center opacity-50">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 text-white font-bold">1</div>
                <div class="ml-4 hidden sm:block">
                    <h2 class="text-lg font-semibold text-gray-900">Data Diri</h2>
                </div>
            </div>
            <div class="hidden sm:block h-1 w-16 bg-indigo-600 rounded"></div>
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 text-white font-bold">2</div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold text-gray-900">Pilih Kelas</h2>
                    <p class="text-sm text-gray-500">Tentukan Jadwal Belajar</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-2">Pilih Jadwal Kelas</h3>
        
        <form action="{{ route('registration.store_class', $student) }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($classes as $class)
                    <label class="relative flex flex-col bg-white p-4 rounded-lg border-2 cursor-pointer hover:border-indigo-200 focus-within:border-indigo-600 transition">
                        <input type="radio" name="class_id" value="{{ $class->id }}" class="sr-only peer" required>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-gray-900">{{ $class->name }}</span>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-medium px-2 py-1 bg-green-100 text-green-800 rounded-full">Sisa: {{ $class->quota - $class->filled }}</span>
                                <span class="text-xs font-semibold text-indigo-700">Rp {{ number_format($class->price,0,',','.') }}</span>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500 mb-1">{{ $class->day }}</div>
                        <div class="text-sm text-gray-500">{{ $class->time }}</div>
                        
                        <!-- Selected Indicator -->
                        <div class="absolute top-4 right-4 hidden peer-checked:block">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="absolute inset-0 border-2 border-indigo-600 rounded-lg hidden peer-checked:block pointer-events-none"></div>
                    </label>
                @empty
                    <div class="col-span-2 text-center py-8 text-gray-500">
                        Tidak ada kelas yang tersedia saat ini. Silakan hubungi admin.
                    </div>
                @endforelse
            </div>

            @error('class_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <div class="flex justify-between pt-4">
                <a href="{{ route('registration.data', $student) }}" class="text-gray-600 font-medium hover:text-gray-900 px-4 py-2">
                    &larr; Kembali
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Pilih Kelas & Lanjut Pembayaran &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
