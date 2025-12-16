@extends('layouts.app')

@section('title', 'Dashboard - Bimba AIUEO Unit Klender')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-500">Selamat datang, {{ Auth::user()->name }}!</p>
        {{-- DEBUG: Remove after verifying --}}
        {{-- {{ dump(Auth::user()->trials) }} --}}
    </div>

    @if(Auth::user()->role === 'admin')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Total Pendaftar</h3>
                <p class="text-3xl font-bold text-indigo-600">0</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Menunggu Verifikasi</h3>
                <p class="text-3xl font-bold text-orange-500">0</p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Siswa Aktif</h3>
                <p class="text-3xl font-bold text-green-500">0</p>
            </div>
        </div>
    @else
        {{-- Parent View --}}
        <div class="space-y-6">


            <div class="flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-900">Data Anak</h2>
                <a href="{{ route('registration.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Daftar Siswa
                </a>
            </div>

            @if(Auth::user()->students->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada data anak</h3>
                    <p class="mt-1 text-gray-500">Silakan daftarkan anak Anda untuk memulai.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach(Auth::user()->students as $student)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $student->full_name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $student->nickname }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold 
                                        {{ $student->status === 'active' ? 'bg-green-100 text-green-800' : 
                                           ($student->status === 'verified' ? 'bg-blue-100 text-blue-800' : 
                                           ($student->status === 'needs_revision' ? 'bg-red-100 text-red-800' :
                                           ($student->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'))) }}">
                                        {{ strtoupper(str_replace('_', ' ', $student->status)) }}
                                    </span>
                                </div>
                                
                                <div class="mb-4">
                                    <a href="{{ route('student.show', $student) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium hover:underline">
                                        Lihat Detail &rarr;
                                    </a>
                                </div>
                                
                                <div class="space-y-3">
                                    @if($student->status === 'draft')
                                        <a href="{{ route('registration.data', $student) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                            Lanjutkan Pendaftaran
                                        </a>
                                    @elseif($student->status === 'needs_revision')
                                        <div class="mb-3 p-3 bg-red-50 border border-red-100 rounded-lg">
                                            <p class="text-sm text-red-800 font-medium mb-1">Catatan Revisi:</p>
                                            <p class="text-sm text-red-600">{{ $student->revision_note }}</p>
                                        </div>
                                        <a href="{{ route('registration.data', $student) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                            Perbaiki Data
                                        </a>
                                    @elseif($student->status === 'verified')
                                        <a href="{{ route('registration.class', $student) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                            Pilih Kelas
                                        </a>
                                    @elseif($student->status === 'awaiting_payment')
                                        <a href="{{ route('payment.index', $student) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                            Bayar Sekarang
                                        </a>
                                    @elseif($student->status === 'paid')
                                        <div class="text-center p-2 bg-blue-50 rounded-lg text-sm text-blue-800">
                                            Menunggu verifikasi pembayaran
                                        </div>
                                    @elseif($student->status === 'active')
                                        <div class="text-center p-2 bg-green-50 rounded-lg text-sm text-green-800 font-medium">
                                            Siswa Aktif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Trial Status Section -->
            @if(Auth::user()->trials->isNotEmpty())
                <div class="mt-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Status Trial Gratis</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach(Auth::user()->trials as $trial)
                            <div class="bg-indigo-50 rounded-2xl shadow-sm border border-indigo-100 overflow-hidden hover:shadow-md transition">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-bold text-indigo-900">{{ $trial->child_name }}</h3>
                                            <p class="text-sm text-indigo-600">Orang Tua: {{ $trial->parent_name }}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                                            {{ $trial->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : 
                                               ($trial->status === 'scheduled' ? 'bg-blue-200 text-blue-800' : 
                                               ($trial->status === 'completed' ? 'bg-green-200 text-green-800' : 
                                               ($trial->status === 'registered' ? 'bg-purple-200 text-purple-800' : 'bg-gray-200 text-gray-800'))) }}">
                                            {{ ucfirst($trial->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        @if($trial->scheduled_at)
                                            <div class="bg-white/60 p-3 rounded-lg border border-indigo-100">
                                                <p class="text-xs text-indigo-700 font-bold uppercase tracking-wide mb-1">Jadwal Trial</p>
                                                <p class="text-indigo-900 font-bold">
                                                    {{ $trial->scheduled_at->translatedFormat('l, d F Y') }}
                                                </p>
                                                <p class="text-indigo-700 font-medium">
                                                    Pukul {{ $trial->scheduled_at->format('H:i') }} WIB
                                                </p>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Jadwal:</span> 
                                                {{ $trial->status === 'pending' ? 'Menunggu konfirmasi admin' : 
                                                   ($trial->status === 'scheduled' ? 'Silakan cek WhatsApp Anda' : 
                                                   ($trial->status === 'completed' ? 'Trial selesai' : 'Sudah terdaftar')) }}
                                            </p>
                                        @endif

                                        @if($trial->status === 'completed' || $trial->status === 'scheduled')
                                            <div class="mt-4 pt-4 border-t border-indigo-100">
                                                <a href="{{ route('registration.create') }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                                    Lanjut Daftar Siswa Tetap &rarr;
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
