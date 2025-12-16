@extends('layouts.app')

@section('title', 'Edit Kelas - BIMBA AIUEO Unit Klender')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Kelas</h1>
        <a href="{{ route('admin.classes.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
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
        <form action="{{ route('admin.classes.update', $class) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                <input type="text" name="name" value="{{ old('name', $class->name) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Program</label>
                <select name="program" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">(Pilih program)</option>
                    <option value="PDI" {{ old('program', $class->program) == 'PDI' ? 'selected' : '' }}>PDI</option>
                    <option value="PDS" {{ old('program', $class->program) == 'PDS' ? 'selected' : '' }}>PDS</option>
                    <option value="PBM" {{ old('program', $class->program) == 'PBM' ? 'selected' : '' }}>PBM</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Biaya (Rp)</label>
                <input type="number" name="price" required min="0" value="{{ old('price', $class->price ?? 0) }}" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                <input list="days" name="day" value="{{ old('day', $class->day) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Pilih atau ketik hari...">
                <datalist id="days">
                    <option value="Senin-Kamis">
                    <option value="Selasa-Jumat">
                    <option value="Rabu-Sabtu">
                </datalist>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam</label>
                <input type="text" name="time" value="{{ old('time', $class->time) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kuota</label>
                <input type="number" name="quota" value="{{ old('quota', $class->quota) }}" required min="1" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.classes.index') }}" class="flex-1 text-center bg-gray-100 text-gray-700 py-2 rounded-lg font-semibold hover:bg-gray-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
