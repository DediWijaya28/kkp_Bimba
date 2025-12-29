@extends('layouts.app')

@section('title', 'Tambah Siswa Baru - Bimba AIUEO Unit Klender')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Siswa Baru</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">&larr; Kembali ke Dashboard</a>
    </div>

    <form action="{{ route('admin.store') }}" method="POST" class="space-y-6">
        @csrf
        
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Akun Pengguna (Admin Only Section) -->
        <div class="bg-yellow-50 p-6 rounded-2xl shadow-sm border border-yellow-200">
            <h3 class="text-lg font-bold text-yellow-900 mb-4 border-b border-yellow-200 pb-2">1. Buat Akun Pengguna (Wajib)</h3>
            <p class="text-sm text-yellow-800 mb-4">
                Admin wajib membuatkan akun untuk siswa. 
                Mohon catat <strong>Email</strong> dan <strong>Password</strong> ini untuk diberikan kepada Orang Tua siswa.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Login</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 shadow-sm" placeholder="contoh: nama@email.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password Login</label>
                    <input type="text" name="password" value="{{ old('password', Str::random(8)) }}" required class="w-full rounded-xl border-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 shadow-sm" placeholder="Minimal 8 karakter">
                </div>
            </div>
        </div>

        <!-- Data Anak (Copied from User Form) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-6 border-b pb-2">
                <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">2. Data Calon Siswa</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm text-transform: uppercase;" placeholder="Sesuai Akta Kelahiran">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Panggilan <span class="text-red-500">*</span></label>
                    <input type="text" name="nickname" value="{{ old('nickname') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Nama panggilan sehari-hari">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="gender" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm">
                        <option value="">Pilih...</option>
                        <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="birth_place" value="{{ old('birth_place') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm capitalize" placeholder="Kota kelahiran">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Agama <span class="text-red-500">*</span></label>
                    <select name="religion" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm">
                        <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>

                <!-- Updated Address Layout using Alpine -->
                 <div class="col-span-2" x-data="addressForm()">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Alamat Lengkap <span class="text-red-500">*</span></label>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <!-- Hidden Inputs to store names -->
                        <input type="hidden" name="province_name" :value="getProvinceName()">
                        <input type="hidden" name="city_name" :value="getCityName()">
                        <input type="hidden" name="district_name" :value="getDistrictName()">
                        <input type="hidden" name="village_name" :value="getVillageName()">

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Provinsi</label>
                            <select name="province_id" x-model="selectedProvince" @change="loadCities()" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm">
                                <option value="">Pilih Provinsi</option>
                                <template x-for="province in provinces" :key="province.id">
                                    <option :value="province.id" x-text="province.name" :selected="province.id == selectedProvince"></option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Kota/Kabupaten</label>
                            <select name="city_id" x-model="selectedCity" @change="loadDistricts()" :disabled="!selectedProvince" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm disabled:bg-gray-100 disabled:cursor-not-allowed">
                                <option value="">Pilih Kota/Kabupaten</option>
                                <template x-for="city in cities" :key="city.id">
                                    <option :value="city.id" x-text="city.name" :selected="city.id == selectedCity"></option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Kecamatan</label>
                            <select name="district_id" x-model="selectedDistrict" @change="loadVillages()" :disabled="!selectedCity" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm disabled:bg-gray-100 disabled:cursor-not-allowed">
                                <option value="">Pilih Kecamatan</option>
                                <template x-for="district in districts" :key="district.id">
                                    <option :value="district.id" x-text="district.name" :selected="district.id == selectedDistrict"></option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Kelurahan/Desa</label>
                            <select name="village_id" x-model="selectedVillage" :disabled="!selectedDistrict" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm disabled:bg-gray-100 disabled:cursor-not-allowed">
                                <option value="">Pilih Kelurahan</option>
                                <template x-for="village in villages" :key="village.id">
                                    <option :value="village.id" x-text="village.name" :selected="village.id == selectedVillage"></option>
                                </template>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jalan</label>
                            <input type="text" name="street_address" value="{{ old('street_address') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Ketikkan nama jalanmu">
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                                <input type="number" name="rt" value="{{ old('rt') }}" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm" placeholder="001">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                                <input type="number" name="rw" value="{{ old('rw') }}" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm" placeholder="005">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Rumah</label>
                                <input type="text" name="house_number" value="{{ old('house_number') }}" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm" placeholder="No.">
                            </div>
                        </div>
                        
                        <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                             <input type="number" name="postal_code" value="{{ old('postal_code') }}" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Kode Pos">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua (Copied from User Form) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-6 border-b pb-2">
                <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">3. Data Orang Tua</h3>
            </div>

            @php
                $occupations = [
                    'PNS (Pegawai Negeri Sipil)',
                    'TNI/Polri',
                    'Karyawan BUMN/BUMD', 
                    'Karyawan Swasta', 
                    'Wiraswasta/Pedagang',
                    'Tenaga Medis (Dokter/Perawat/Bidan)',
                    'Guru/Dosen/Tenaga Pendidik',
                    'Pengacara/Notaris',
                    'Seniman/Artis',
                    'Supir/Kurir',
                    'Petani/Peternak/Nelayan', 
                    'Buruh', 
                    'Ibu Rumah Tangga', 
                    'Pensiunan',
                    'Tidak Bekerja', 
                    'Lainnya'
                ];
            @endphp

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah <span class="text-red-500">*</span></label>
                    <input type="text" name="father_name" value="{{ old('father_name') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Nama Lengkap Ayah">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah <span class="text-red-500">*</span></label>
                    <select name="father_occupation" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm">
                        <option value="">Pilih Pekerjaan</option>
                        @foreach($occupations as $job)
                            <option value="{{ $job }}" {{ old('father_occupation') == $job ? 'selected' : '' }}>{{ $job }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp Ayah <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="father_phone" value="{{ old('father_phone') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm" placeholder="08xxxxxxxxxx">
                    <p class="text-xs text-gray-500 mt-1">Nomor ini juga akan digunakan untuk konfirmasi pendaftaran.</p>
                </div>
                
                <div class="col-span-2 border-t border-gray-100 my-2"></div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu <span class="text-red-500">*</span></label>
                    <input type="text" name="mother_name" value="{{ old('mother_name') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Nama Lengkap Ibu">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu <span class="text-red-500">*</span></label>
                    <select name="mother_occupation" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm">
                        <option value="">Pilih Pekerjaan</option>
                        @foreach($occupations as $job)
                            <option value="{{ $job }}" {{ old('mother_occupation') == $job ? 'selected' : '' }}>{{ $job }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Ibu <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 px-4 py-3 shadow-sm" placeholder="08xxxxxxxxxx">
                    <p class="text-xs text-gray-500 mt-1">Nomor ini akan digunakan untuk konfirmasi pendaftaran.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-6">
            <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                Batal
            </a>
            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition shadow-lg">
                Simpan & Daftarkan Siswa
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('addressForm', () => ({
        provinces: [],
        cities: [],
        districts: [],
        villages: [],
        
        selectedProvince: '{{ old('province_id') }}',
        selectedCity: '{{ old('city_id') }}',
        selectedDistrict: '{{ old('district_id') }}',
        selectedVillage: '{{ old('village_id') }}',

        init() {
            this.loadProvinces();
            if(this.selectedProvince) this.loadCities();
            if(this.selectedCity) this.loadDistricts();
            if(this.selectedDistrict) this.loadVillages();
        },

        async loadProvinces() {
            try {
                let res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`);
                this.provinces = await res.json();
            } catch(e) { console.error(e); }
        },
        async loadCities() {
            if(!this.selectedProvince) return;
            try {
                let res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.selectedProvince}.json`);
                this.cities = await res.json();
            } catch(e) { console.error(e); }
        },
        async loadDistricts() {
            if(!this.selectedCity) return;
            try {
                let res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.selectedCity}.json`);
                this.districts = await res.json();
            } catch(e) { console.error(e); }
        },
        async loadVillages() {
            if(!this.selectedDistrict) return;
            try {
                let res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.selectedDistrict}.json`);
                this.villages = await res.json();
            } catch(e) { console.error(e); }
        },
        getProvinceName() { 
            let item = this.provinces.find(i => i.id == this.selectedProvince);
            return item ? item.name : '';
        },
        getCityName() { 
            let item = this.cities.find(i => i.id == this.selectedCity);
            return item ? item.name : '';
        },
        getDistrictName() { 
            let item = this.districts.find(i => i.id == this.selectedDistrict);
            return item ? item.name : '';
        },
        getVillageName() { 
            let item = this.villages.find(i => i.id == this.selectedVillage);
            return item ? item.name : '';
        }
    }))
});
</script>
@endsection
