@extends('layouts.app')

@section('title', 'Manajemen Kelas - BIMBA AIUEO Unit Klender')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-black-900">Manajemen Kelas</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-black-600 hover:text-black-900">&larr; Kembali ke Dashboard</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Form Tambah Kelas -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-black-100 p-6 sticky top-24"
                 x-data="{
                     program: '{{ old('program') }}',
                     price: '{{ old('price', 0) }}',
                     time: '{{ old('time') }}',
                     timeSlots: [],
                     updateProgramDetails() {
                         switch(this.program) {
                             case 'PDI':
                                 this.price = 500000;
                                 this.timeSlots = ['08.00 - 08.45', '08.45 - 09.30', '09.30 - 10.15', '10.15 - 11.00'];
                                 break;
                             case 'PDS':
                                 this.price = 300000;
                                 this.timeSlots = ['08.00 - 09.00', '09.00 - 10.00', '10.00 - 11.00', '13.00 - 14.00', '14.00 - 15.00'];
                                 break;
                             case 'PBM':
                                 this.price = 500000;
                                 this.timeSlots = ['13.00 - 14.00', '14.00 - 15.00'];
                                 break;
                             default:
                                 this.price = 0;
                                 this.timeSlots = [];
                         }
                     }
                 }"
                 x-init="updateProgramDetails()">
                <h3 class="text-lg font-bold text-black-900 mb-4">Tambah Kelas Baru</h3>
                @if(session('error'))
                    <div class="mb-4 p-3 rounded bg-red-50 text-red-700 border border-red-100">{{ session('error') }}</div>
                @endif
                @if($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-50 text-red-700 border border-red-100">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-black-700 mb-1">Nama Kelas</label>
                        <input type="text" name="name" required placeholder="Contoh: Sesi Pagi" class="w-full rounded-lg border-black-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-black-700 mb-1">Program</label>
                        <select name="program" x-model="program" @change="updateProgramDetails()" class="w-full rounded-lg border-black-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">(Pilih program)</option>
                            <option value="PDI">PDI (Peserta Didik Intensif)</option>
                            <option value="PDS">PDS (Peserta Didik Standar)</option>
                            <option value="PBM">PBM (Program Belajar Mandiri)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-black-700 mb-1">Biaya/Bulan (Rp)</label>
                        <input type="number" name="price" x-model="price" required min="0" class="w-full rounded-lg border-black-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-black-700 mb-1">Hari</label>
                        <input list="days" name="day" required class="w-full rounded-lg border-black-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Pilih atau ketik hari...">
                        <datalist id="days">
                            <option value="Senin">
                            <option value="Selasa">
                            <option value="Rabu">
                            <option value="Kamis">
                            <option value="Jumat">
                        </datalist>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-black-700 mb-1">Jam</label>
                        <select name="time" x-model="time" required class="w-full rounded-lg border-black-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">(Pilih jam belajar)</option>
                            <template x-for="slot in timeSlots" :key="slot">
                                <option :value="slot" x-text="slot"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-black-700 mb-1">Kuota</label>
                        <input type="number" name="quota" required min="1" value="6" class="w-full rounded-lg border-black-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Simpan Kelas
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Kelas -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-black-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-black-200">
                        <thead class="bg-black-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Nama Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Program</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Jadwal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Biaya/Bulan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Terisi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-black-200">
                            @forelse($classes as $class)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-black-900">{{ $class->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-black-900">{{ $class->program ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-black-900">{{ $class->day }}</div>
                                        <div class="text-xs text-black-500">{{ $class->time }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-black-900">Rp {{ number_format($class->price,0,',','.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-black-900">
                                            {{ $class->filled }} / {{ $class->quota }} Siswa
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center gap-3">
                                        <a href="{{ route('admin.classes.edit', $class) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-black-500">Belum ada kelas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
