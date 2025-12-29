@extends('layouts.app')

@section('title', 'Langkah 1: Data Diri')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <div class="flex justify-end mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:text-indigo-600 hover:border-indigo-200 hover:shadow-sm transition-all duration-200 group">
                <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        </div>
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 text-white font-bold">1</div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold text-gray-900">Data Diri</h2>
                    <p class="text-sm text-gray-500">Isi data siswa dan orang tua</p>
                </div>
            </div>
            <div class="hidden sm:block h-1 w-16 bg-gray-200 rounded"></div>
            <div class="flex items-center opacity-50">
                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 text-gray-600 font-bold">2</div>
                <div class="ml-4 hidden sm:block">
                    <h2 class="text-lg font-semibold text-gray-900">Pilih Kelas</h2>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('registration.store_data') }}" method="POST" class="space-y-8">
        @csrf
        @if($student)
            <input type="hidden" name="student_id" value="{{ $student->id }}">
        @endif
        
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded">
                <strong class="block font-semibold">Terdapat kesalahan pada input:</strong>
                <ul class="mt-2 text-sm list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Data Anak -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-6 border-b pb-2">
                <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Data Calon Siswa</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name', $student?->full_name ?? '') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Sesuai Akta Kelahiran">
                    @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Panggilan <span class="text-red-500">*</span></label>
                    <input type="text" name="nickname" value="{{ old('nickname', $student?->nickname ?? '') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Nama panggilan sehari-hari">
                    @error('nickname') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="gender" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm">
                        <option value="">Pilih...</option>
                        <option value="L" {{ (old('gender', $student?->gender ?? '') == 'L') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ (old('gender', $student?->gender ?? '') == 'P') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $student?->birth_place ?? '') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm capitalize" placeholder="Kota kelahiran">
                    @error('birth_place') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $student?->birth_date ?? '') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm">
                    @error('birth_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>


                    <label class="block text-sm font-medium text-gray-700 mb-1">Agama <span class="text-red-500">*</span></label>
                    <select name="religion" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm">
                        <option value="Islam" {{ (old('religion', $student?->religion ?? '') == 'Islam') ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ (old('religion', $student?->religion ?? '') == 'Kristen') ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ (old('religion', $student?->religion ?? '') == 'Katolik') ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ (old('religion', $student?->religion ?? '') == 'Hindu') ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ (old('religion', $student?->religion ?? '') == 'Buddha') ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ (old('religion', $student?->religion ?? '') == 'Konghucu') ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('religion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Updated Address Layout -->
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
                            <select name="province_id" x-model="selectedProvince" @change="loadCities()" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm">
                                <option value="">Pilih Provinsi</option>
                                <template x-for="province in provinces" :key="province.id">
                                    <option :value="province.id" x-text="province.name" :selected="province.id == selectedProvince"></option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Kota/Kabupaten</label>
                            <select name="city_id" x-model="selectedCity" @change="loadDistricts()" :disabled="!selectedProvince" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm disabled:opacity-60 disabled:cursor-not-allowed">
                                <option value="">Pilih Kota/Kabupaten</option>
                                <template x-for="city in cities" :key="city.id">
                                    <option :value="city.id" x-text="city.name" :selected="city.id == selectedCity"></option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Kecamatan</label>
                            <select name="district_id" x-model="selectedDistrict" @change="loadVillages()" :disabled="!selectedCity" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm disabled:opacity-60 disabled:cursor-not-allowed">
                                <option value="">Pilih Kecamatan</option>
                                <template x-for="district in districts" :key="district.id">
                                    <option :value="district.id" x-text="district.name" :selected="district.id == selectedDistrict"></option>
                                </template>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Kelurahan/Desa</label>
                            <select name="village_id" x-model="selectedVillage" :disabled="!selectedDistrict" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm disabled:opacity-60 disabled:cursor-not-allowed">
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
                            <input type="text" name="street_address" value="{{ old('street_address', $student?->street_address ?? '') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Ketikkan nama jalanmu">
                            @error('street_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">RT</label>
                            <input type="number" name="rt" value="{{ old('rt', $student?->rt ?? '') }}" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Ketikkan RT-mu">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">RW</label>
                            <input type="number" name="rw" value="{{ old('rw', $student?->rw ?? '') }}" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Ketikkan RW-mu">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rumah</label>
                            <input type="text" name="house_number" value="{{ old('house_number', $student?->house_number ?? '') }}" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Ketikkan Nomor rumah-mu">
                        </div>
                        
                        <div>
                             <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                             <input type="number" name="postal_code" value="{{ old('postal_code', $student?->postal_code ?? '') }}" class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Kode Pos">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Orang Tua -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-6 border-b pb-2">
                <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Data Orang Tua</h3>
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
                    <input type="text" name="father_name" value="{{ old('father_name', $parent?->father_name ?? '') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Nama Lengkap Ayah">
                    @error('father_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah <span class="text-red-500">*</span></label>
                    <select name="father_occupation" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm">
                        <option value="">Pilih Pekerjaan</option>
                        @foreach($occupations as $job)
                            <option value="{{ $job }}" {{ (old('father_occupation', $parent?->father_occupation ?? '') == $job) ? 'selected' : '' }}>{{ $job }}</option>
                        @endforeach
                    </select>
                    @error('father_occupation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp Ayah <span class="text-red-500">*</span></label>
                    <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="father_phone" value="{{ old('father_phone', $parent?->father_phone ?? '') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="08xxxxxxxxxx">
                    <p class="text-xs text-gray-500 mt-1">Nomor ini juga akan digunakan untuk konfirmasi pendaftaran.</p>
                    @error('father_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div class="col-span-2 border-t border-gray-100 my-2"></div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu <span class="text-red-500">*</span></label>
                    <input type="text" name="mother_name" value="{{ old('mother_name', $parent?->mother_name ?? '') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="Nama Lengkap Ibu">
                    @error('mother_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu <span class="text-red-500">*</span></label>
                    <select name="mother_occupation" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm">
                        <option value="">Pilih Pekerjaan</option>
                        @foreach($occupations as $job)
                            <option value="{{ $job }}" {{ (old('mother_occupation', $parent?->mother_occupation ?? '') == $job) ? 'selected' : '' }}>{{ $job }}</option>
                        @endforeach
                    </select>
                    @error('mother_occupation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon Ibu <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $parent?->phone ?? '') }}" required class="w-full rounded-xl border-gray-400 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all duration-200 px-4 py-3 shadow-sm" placeholder="08xxxxxxxxxx">
                    <p class="text-xs text-gray-500 mt-1">Nomor ini akan digunakan untuk konfirmasi pendaftaran.</p>
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end items-center bg-gray-50 px-6 py-4 rounded-b-2xl mt-8">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg hover:shadow-indigo-500/30">
                Lanjut (Pilih Kelas) &rarr;
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
            // Prefer server-side old/db value, otherwise fallback to localStorage
            selectedProvince: '{{ old('province_id', $student?->province_id ?? '') }}',
            selectedCity: '{{ old('city_id', $student?->city_id ?? '') }}',
            selectedDistrict: '{{ old('district_id', $student?->district_id ?? '') }}',
            selectedVillage: '{{ old('village_id', $student?->village_id ?? '') }}',
            streetAddress: '{{ old('street_address', $student?->street_address ?? '') }}',
            suggestions: [],
            loading: false,
            loadingAddress: false,

            async init() {
                // Setup watchers to save to localStorage
                this.$watch('selectedProvince', val => localStorage.setItem('reg_province_id', val));
                this.$watch('selectedCity', val => localStorage.setItem('reg_city_id', val));
                this.$watch('selectedDistrict', val => localStorage.setItem('reg_district_id', val));
                this.$watch('selectedVillage', val => localStorage.setItem('reg_village_id', val));
                this.$watch('streetAddress', val => localStorage.setItem('reg_street_address', val));

                this.loading = true;
                try {
                    const response = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    this.provinces = await response.json();

                    if (this.selectedProvince) {
                        await this.loadCities();
                        if (this.selectedCity) {
                            await this.loadDistricts();
                            if (this.selectedDistrict) {
                                await this.loadVillages();
                            }
                        }
                    }
                } catch (e) {
                    console.error('Failed to load provinces', e);
                } finally {
                    this.loading = false;
                }
            },

            async searchAddress() {
                if (this.streetAddress.length < 3) {
                    this.suggestions = [];
                    return;
                }
                this.loadingAddress = true;
                try {
                    const query = encodeURIComponent(this.streetAddress);
                    const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${query}&format=json&addressdetails=1&countrycodes=id&limit=5`);
                    this.suggestions = await response.json();
                } catch (e) {
                    console.error('Address search failed', e);
                } finally {
                    this.loadingAddress = false;
                }
            },

            selectAddress(item) {
                this.streetAddress = item.display_name;
                this.suggestions = [];
            },

            async loadCities() {
                if (!this.selectedProvince) return;
                this.loading = true;
                this.cities = [];
                // ONLY reset children if the user manually changed the parent (not during initial load)
                // We can check if the current selectedCity is valid for this province later, 
                // but for simplicity, if we are loading cities, we usually want to keep the selectedCity 
                // if it was set during init (restored from storage).
                // However, "change" event calls this. If "change" event, we might want to clear children.
                // But x-model binding updates before change. 
                // Best approach: If the existing selectedCity is not in the new list, it will naturally be invalid, 
                // but for UI usage, if this is triggered by a user change, they likely want to reset.
                // We'll trust the init flow (which calls loadCities) to preserve values, 
                // and the watcher logic implies if the value changes, it saves.
                
                try {
                    const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.selectedProvince}.json`);
                    this.cities = await response.json();
                } catch (e) {
                    console.error('Failed to load cities', e);
                } finally {
                    this.loading = false;
                }
            },

            async loadDistricts() {
                if (!this.selectedCity) return;
                this.loading = true;
                this.districts = [];
                try {
                    const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.selectedCity}.json`);
                    this.districts = await response.json();
                } catch (e) {
                    console.error('Failed to load districts', e);
                } finally {
                    this.loading = false;
                }
            },

            async loadVillages() {
                if (!this.selectedDistrict) return;
                this.loading = true;
                this.villages = [];
                try {
                    const response = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.selectedDistrict}.json`);
                    this.villages = await response.json();
                } catch (e) {
                    console.error('Failed to load villages', e);
                } finally {
                    this.loading = false;
                }
            },

            getProvinceName() { const id = this.selectedProvince; return (this.provinces.find(p => String(p.id) === String(id)) || {}).name || ''; },
            getCityName() { const id = this.selectedCity; return (this.cities.find(c => String(c.id) === String(id)) || {}).name || ''; },
            getDistrictName() { const id = this.selectedDistrict; return (this.districts.find(d => String(d.id) === String(id)) || {}).name || ''; },
            getVillageName() { const id = this.selectedVillage; return (this.villages.find(v => String(v.id) === String(id)) || {}).name || ''; }
        }));
    });

    // Generic Form Persistence for non-Alpine fields
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input:not([type="hidden"]):not([type="password"]), select, textarea');

        // Restore values
        inputs.forEach(input => {
            // Skip if controlled by Alpine (address fields have x-model)
            if (input.hasAttribute('x-model')) return;

            const name = input.name;
            const storedValue = localStorage.getItem('reg_' + name);
            if (storedValue && !input.value) { // Only restore if server/old value is empty
                if (input.type === 'radio' || input.type === 'checkbox') {
                    if (input.value === storedValue) {
                        input.checked = true;
                    }
                } else {
                    input.value = storedValue;
                }
            }
        });

        // Save values on change
        form.addEventListener('input', function(e) {
            const input = e.target;
            if (input.name && input.type !== 'password' && !input.hasAttribute('x-model')) {
                localStorage.setItem('reg_' + input.name, input.value);
            }
        });
        
        form.addEventListener('change', function(e) {
            const input = e.target;
             if (input.name && (input.type === 'radio' || input.type === 'checkbox') && !input.hasAttribute('x-model')) {
                localStorage.setItem('reg_' + input.name, input.value);
            } else if (input.tagName === 'SELECT' && !input.hasAttribute('x-model')) {
                localStorage.setItem('reg_' + input.name, input.value);
            }
        });

        // Optional: Clear storage on successful submit? 
        // We'll leave it for now in case submission fails due to server error so data is safe.
        // If you want to clear it, you'd add a 'submit' listener that checks validity.
    });
</script>
@endsection
