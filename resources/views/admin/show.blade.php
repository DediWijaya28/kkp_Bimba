
@extends('layouts.app')

@section('title', 'Detail Siswa - Bimba AIUEO Unit Klender')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-black">Detail Pendaftaran</h1>
        <div class="flex space-x-3">
            <a href="{{ route('admin.edit', $student) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition text-sm font-medium">
                Edit Data
            </a>
            <form action="{{ route('admin.destroy', $student) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm font-medium">
                    Hapus Siswa
                </button>
            </form>
            <a href="{{ route('admin.dashboard') }}" class="text-black hover:text-black flex items-center ml-4">&larr; Kembali</a>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex justify-between items-center">
        <div>
            <span class="text-black text-sm">Status Saat Ini:</span>
            <span class="ml-2 px-3 py-1 rounded-full text-sm font-bold 
                {{ $student->status === 'verified' ? 'bg-green-100 text-green-800' : 
                   ($student->status === 'submitted' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-black') }}">
                {{ strtoupper(str_replace('_', ' ', $student->status)) }}
            </span>
        </div>
        <div class="space-x-2">
            @if($student->status !== 'verified' && $student->status !== 'active')
            @if($student->status === 'paid')
                <form action="{{ route('admin.verify', $student) }}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="status" value="verified">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm font-medium">
                        Verifikasi (Approve)
                    </button>
                </form>
            @endif
                <button onclick="document.getElementById('revisionModal').classList.remove('hidden')" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm font-medium">
                    Minta Revisi
                </button>
            @endif
        </div>
    </div>

    <!-- Revision Modal -->
    <div id="revisionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Catatan Revisi</h3>
                <form action="{{ route('admin.verify', $student) }}" method="POST" class="mt-2 px-7 py-3">
                    @csrf
                    <input type="hidden" name="status" value="needs_revision">
                    <textarea name="note" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Ketik alasan revisi..."></textarea>
                    <div class="items-center px-4 py-3">
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Kirim Permintaan Revisi
                        </button>
                    </div>
                </form>
                <div class="items-center px-4 py-3">
                    <button onclick="document.getElementById('revisionModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Data Siswa -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-black mb-4">Data Siswa</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-black">Nama Lengkap</dt>
                    <dd class="font-medium text-black">{{ $student->full_name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black">Panggilan</dt>
                    <dd class="font-medium text-black">{{ $student->nickname }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black">TTL</dt>
                    <dd class="font-medium text-black">{{ $student->birth_place }}, {{ $student->birth_date }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black">Jenis Kelamin</dt>
                    <dd class="font-medium text-black">{{ $student->gender }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black">Agama</dt>
                    <dd class="font-medium text-black">{{ $student->religion }}</dd>
                </div>
                <div>
                    <dt class="text-black mb-1">Alamat</dt>
                    <dd class="font-medium text-black">{{ $student->address }}</dd>
                </div>
            </dl>
        </div>

        <!-- Data Orang Tua -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-black mb-4">Data Orang Tua</h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-black">Ayah</dt>
                    <dd class="font-medium text-black">{{ $student->parent->father_name ?? '-' }} ({{ $student->parent->father_occupation ?? '-' }})</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Telepon Ayah</dt>
                    <dd class="font-medium text-gray-900">{{ $student->parent->father_phone ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-black">Ibu</dt>
                    <dd class="font-medium text-black">{{ $student->parent->mother_name ?? '-' }} ({{ $student->parent->mother_occupation ?? '-' }})</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">WhatsApp / Ibu</dt>
                    <dd class="font-medium text-gray-900">{{ $student->parent->phone ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Kelas yang Dipilih -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Kelas yang Dipilih</h3>
            @if($student->classSelections->where('status', 'selected')->count() > 0)
                @foreach($student->classSelections->where('status', 'selected') as $selection)
                    <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-indigo-900">
                                    {{ $selection->schoolClass->program ? $selection->schoolClass->program . ' - ' : '' }}{{ $selection->schoolClass->name }}
                                </h4>
                                <p class="text-sm text-indigo-700">{{ $selection->schoolClass->day }} - {{ $selection->schoolClass->time }}</p>
                            </div>
                            <span class="px-2 py-1 bg-indigo-200 text-indigo-800 text-xs font-bold rounded">TERPILIH</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-gray-500 bg-gray-50 p-4 rounded-lg italic">Belum memilih kelas.</div>
            @endif
        </div>
            @if($student->payment)
                <div class="mt-8 bg-indigo-50 border border-indigo-200 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-indigo-900 mb-4">Informasi Pembayaran</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-indigo-700 font-semibold">Metode Pembayaran</p>
                            <p class="text-indigo-900 capitalize">{{ $student->payment->payment_method ?? 'Transfer' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-indigo-700 font-semibold">Status</p>
                            <p class="text-indigo-900 capitalize">{{ $student->payment->status }}</p>
                        </div>
                    </div>
                    
                    @if($student->payment->proof_path)
                        <div class="mb-6">
                            <p class="text-sm text-indigo-700 font-semibold mb-2">Bukti Transfer</p>
                            <a href="{{ asset('storage/' . $student->payment->proof_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Lihat / Download Bukti
                            </a>
                        </div>
                    @endif

                    <!-- Admin Payment Details Form -->
                    <div class="border-t border-indigo-200 pt-4 mt-4">
                        <h4 class="text-md font-bold text-indigo-900 mb-3">Rincian Bukti Pendaftaran</h4>
                        <form action="{{ route('admin.updatePaymentDetails', $student) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-indigo-800 mb-1">Nomor Registrasi</label>
                                    <input type="text" name="registration_number" value="{{ old('registration_number', $student->payment->registration_number ?? date('dmY').'/REG/'.str_pad($student->id, 3, '0', STR_PAD_LEFT)) }}" class="w-full text-sm rounded-md border-indigo-300 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-indigo-800 mb-1">Penanda Tangan</label>
                                    <input type="text" name="authorized_signer" value="{{ old('authorized_signer', $student->payment->authorized_signer ?? 'Rosdiana') }}" class="w-full text-sm rounded-md border-indigo-300 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-indigo-800 mb-1">Biaya Pendaftaran</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="registration_fee" value="{{ old('registration_fee', ($student->payment->registration_fee > 0 ? $student->payment->registration_fee : ($student->classSelections->where('status', 'selected')->first()?->schoolClass->price ?? 0))) }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-indigo-300 rounded-md" placeholder="0.00">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-indigo-800 mb-1">Biaya SPP</label>
                                    <div class="relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="spp_fee" value="{{ old('spp_fee', $student->payment->spp_fee ?? 0) }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-indigo-300 rounded-md" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-3 pt-2">
                                <button type="submit" class="bg-indigo-600 text-white px-3 py-1.5 rounded text-sm hover:bg-indigo-700 transition">
                                    Simpan Rincian
                                </button>
                                @if($student->payment->registration_number)
                                    <a href="{{ route('payment.print-proof', $student) }}" target="_blank" class="bg-white border border-indigo-600 text-indigo-600 px-3 py-1.5 rounded text-sm hover:bg-indigo-50 transition flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Download PDF Bukti
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if($student->status === 'paid')
                <div class="mt-8 bg-green-50 border border-green-200 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4">Validasi Pembayaran & Aktivasi Siswa</h3>
                    <form action="{{ route('admin.validatePayment', $student) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-green-800 mb-1">Tanggal Mulai Belajar (Hari Pertama)</label>
                            <input type="date" name="start_date" required class="w-full rounded-lg border-green-300 focus:ring-green-500 focus:border-green-500 mb-2">
                            
                            <label class="block text-sm font-medium text-green-800 mb-1">NIM (Nomor Induk Murid)</label>
                            <input type="text" name="nim" required class="w-full rounded-lg border-green-300 focus:ring-green-500 focus:border-green-500" placeholder="Masukkan NIM siswa...">
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                            Validasi Pembayaran & Aktifkan Siswa
                        </button>
                    </form>
                </div>
            @endif

            @if($student->status === 'verified')
                <div class="mt-8 bg-green-50 border border-green-200 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-green-900 mb-4">Aktivasi Siswa</h3>
                    <p class="text-sm text-green-700 mb-4">Data siswa telah diverifikasi. Silakan tentukan tanggal mulai belajar untuk mengaktifkan siswa ini.</p>
                    <form action="{{ route('admin.activate', $student) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-green-800 mb-1">Tanggal Mulai Belajar</label>
                            <input type="date" name="start_date" required class="w-full rounded-lg border-green-300 focus:ring-green-500 focus:border-green-500 mb-2">

                            <label class="block text-sm font-medium text-green-800 mb-1">NIM (Nomor Induk Murid)</label>
                            <input type="text" name="nim" required class="w-full rounded-lg border-green-300 focus:ring-green-500 focus:border-green-500" placeholder="Masukkan NIM siswa...">
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                            Aktifkan Siswa
                        </button>
                    </form>
                </div>
            @endif

            @if($student->status === 'active')
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6 text-center">
                    <h3 class="text-lg font-bold text-blue-900 mb-2">Siswa Aktif</h3>
                    <p class="text-blue-800 mb-1">NIM: <strong>{{ $student->nim }}</strong></p>
                    <p class="text-blue-800">Mulai Belajar: <strong>{{ $student->start_date ? $student->start_date->format('d F Y') : '-' }}</strong></p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
