@extends('layouts.app')

@section('title', 'Edit Data Siswa - Admin')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Data Siswa</h1>
        <a href="{{ route('admin.show', $student) }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali</a>
    </div>

    <form action="{{ route('admin.update', $student) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Data Anak -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-2">Data Siswa</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $student->full_name) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Panggilan</label>
                    <input type="text" name="nickname" value="{{ old('nickname', $student->nickname) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="gender" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="L" {{ (old('gender', $student->gender) == 'L') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ (old('gender', $student->gender) == 'P') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $student->birth_place) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $student->birth_date->format('Y-m-d')) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                    <select name="religion" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="Islam" {{ (old('religion', $student->religion) == 'Islam') ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ (old('religion', $student->religion) == 'Kristen') ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ (old('religion', $student->religion) == 'Katolik') ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ (old('religion', $student->religion) == 'Hindu') ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ (old('religion', $student->religion) == 'Buddha') ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ (old('religion', $student->religion) == 'Konghucu') ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="address" rows="3" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">{{ old('address', $student->address) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-2">Data Orang Tua</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                    <input type="text" name="father_name" value="{{ old('father_name', $student->parent->father_name) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                    <input type="text" name="father_occupation" value="{{ old('father_occupation', $student->parent->father_occupation) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name', $student->parent->mother_name) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                    <input type="text" name="mother_occupation" value="{{ old('mother_occupation', $student->parent->mother_occupation) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $student->parent->phone) }}" required class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
