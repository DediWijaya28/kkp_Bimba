@extends('layouts.app')

@section('title', 'Detail Siswa - Bimba AIUEO Unit Klender')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Detail Siswa</h1>
        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali ke Dashboard</a>
    </div>

    <!-- Status Banner -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <span class="text-gray-500 text-sm">Status Saat Ini:</span>
            <span class="ml-2 px-3 py-1 rounded-full text-sm font-bold 
                {{ $student->status === 'active' ? 'bg-green-100 text-green-800' : 
                   ($student->status === 'verified' ? 'bg-blue-100 text-blue-800' : 
                   ($student->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')) }}">
                {{ strtoupper(str_replace('_', ' ', $student->status)) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Data Siswa -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Data Siswa</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Nama Lengkap</dt>
                    <dd class="font-medium text-gray-900">{{ $student->full_name }}</dd>
                </div>
                @if($student->nim)
                <div class="flex justify-between">
                    <dt class="text-gray-500">NIM</dt>
                    <dd class="font-bold text-green-700">{{ $student->nim }}</dd>
                </div>
                @endif
                <div class="flex justify-between">
                    <dt class="text-gray-500">Panggilan</dt>
                    <dd class="font-medium text-gray-900">{{ $student->nickname }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">TTL</dt>
                    <dd class="font-medium text-gray-900">{{ $student->birth_place }}, {{ $student->birth_date->format('d M Y') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Dokumen & Garansi 
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Dokumen & Bukti</h3> -->

            @if($student->payment && $student->payment->registration_number)
                <div class="mb-6 p-4 bg-indigo-50 border border-indigo-100 rounded-lg">
                    <h4 class="text-sm font-bold text-indigo-900 mb-2">Bukti Pendaftaran & Pembayaran</h4>
                    <p class="text-xs text-indigo-700 mb-3">Dokumen ini adalah bukti sah pendaftaran Anda.</p>
                    <a href="{{ route('payment.print-proof', $student) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Download Bukti Pendaftaran (PDF)
                    </a>
                </div>
            @endif
            
            <div>
                <h4 class="text-sm font-semibold text-gray-900 mb-2">File Upload</h4>
                <ul class="space-y-2">
                    @foreach($student->documents as $doc)
                        <li class="flex items-center justify-between p-2 bg-gray-50 rounded border border-gray-100">
                            <span class="text-sm font-medium text-gray-700 uppercase">{{ $doc->type }}</span>
                            <a href="{{ asset('storage/' . $doc->path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download / Lihat
                            </a>
                        </li>
                    @endforeach
                    @if($student->documents->isEmpty())
                        <li class="text-gray-500 text-sm italic">Belum ada dokumen.</li>
                    @endif
                </ul> -->
            </div>
        </div>
    </div>
</div>
@endsection
