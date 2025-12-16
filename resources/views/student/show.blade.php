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
            <h3 class="text-lg font-bold text-gray-900 mb-4">Dokumen & Garansi</h3>
            
            <div class="mb-6">
                <h4 class="text-sm font-semibold text-gray-900 mb-2">Kartu Garansi</h4>
                @if($student->warranty)
                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-100">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-sm text-green-800">Disetujui pada {{ $student->warranty->signed_at->format('d M Y H:i') }}</span>
                        </div> -->
                        <!-- Placeholder for download PDF if implemented -->
                        <button disabled class="text-xs text-gray-400 cursor-not-allowed">Download PDF</button>
                    </div>
                @else
                    <div class="text-sm text-gray-500 italic">Belum disetujui</div>
                @endif
            </div>

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
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
