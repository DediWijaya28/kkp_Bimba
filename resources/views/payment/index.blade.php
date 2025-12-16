@extends('layouts.app')

@section('title', 'Pembayaran - Bimba AIUEO Unit Klender')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Pembayaran Pendaftaran</h1>
        
        @php
            // Just use the class price as total
            $totalTransfer = $amount;
        @endphp

        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100 mb-8">
            <h3 class="text-lg font-semibold text-indigo-900 mb-4">Invoice Tagihan</h3>
            <div class="flex justify-between items-center mb-2">
                <span class="text-indigo-700">Biaya Pendaftaran</span>
                <span class="font-bold text-indigo-900">Rp {{ number_format($amount,0,',','.') }}</span>
            </div>
            
            <div class="border-t border-indigo-200 pt-4 flex justify-between items-center">
                <span class="text-lg font-bold text-indigo-900">Total Transfer</span>
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-indigo-600 mr-3">Rp {{ number_format($totalTransfer,0,',','.') }}</span>
                    <button type="button" 
                        x-data="{ copied: false }"
                        @click="navigator.clipboard.writeText('{{ $totalTransfer }}'); copied = true; setTimeout(() => copied = false, 2000)"
                        class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition text-sm font-semibold"
                        :class="{'bg-green-100 text-green-700': copied, 'bg-indigo-100 text-indigo-700': !copied}"
                    >
                        <span x-show="!copied">Salin</span>
                        <span x-show="copied">Tersalin!</span>
                    </button>
                </div>
            </div>
            <p class="text-xs text-indigo-600 mt-2 text-right">*Mohon transfer sesuai nominal yang tertera.</p>
        </div>

        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Rekening Tujuan</h3>
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                <div class="flex items-center">
                    <img src="https://www.bankmandiri.co.id/image/layout_set_logo?img_id=31567&t=1757693631430" alt="MANDIRI" class="h-8 mr-4">
                    <div>
                        <p class="font-bold text-gray-900 text-lg">1650066655540</p>
                        <p class="text-sm text-gray-500">a.n. Pengembangan Anak Indonesia</p>
                    </div>
                </div>
                <button type="button" 
                    x-data="{ copied: false }"
                    @click="navigator.clipboard.writeText('1650066655540'); copied = true; setTimeout(() => copied = false, 2000)"
                    class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-semibold"
                    :class="{'bg-green-100 text-green-700': copied, 'bg-gray-100 text-gray-700': !copied}"
                >
                    <span x-show="!copied">Salin</span>
                    <span x-show="copied">Tersalin!</span>
                </button>
            </div>
        </div>

        <form action="{{ route('payment.store', $student) }}" method="POST" enctype="multipart/form-data" x-data="{ fileName: '' }">
            @csrf
            <input type="hidden" name="payment_method" value="transfer">

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-lg transition-colors"
                     :class="fileName ? 'border-green-400 bg-green-50' : 'border-gray-300 hover:border-indigo-500'">
                    <div class="space-y-1 text-center">
                        <!-- Default Icon -->
                        <svg x-show="!fileName" class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <!-- Success/File Icon -->
                        <div x-show="fileName" class="mx-auto h-12 w-12 text-green-500 flex items-center justify-center">
                            <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        
                        <div class="flex text-sm text-gray-600 justify-center">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 px-2">
                                <span x-text="fileName ? 'Ganti file' : 'Upload file'">Upload file</span>
                                <input id="file-upload" name="proof" type="file" class="sr-only" accept=".jpg,.jpeg,.png,.pdf" 
                                       @change="fileName = $event.target.files[0].name" required>
                            </label>
                            <p class="pl-1" x-show="!fileName">atau drag and drop</p>
                        </div>
                        <p class="text-sm font-semibold text-gray-800" x-show="fileName" x-text="fileName"></p>
                        <p class="text-xs text-gray-500" x-show="!fileName">PNG, JPG, PDF up to 2MB</p>
                    </div>
                </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Konfirmasi Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection
