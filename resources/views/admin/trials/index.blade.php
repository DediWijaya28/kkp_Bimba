@extends('layouts.app')

@section('title', 'Data Trial - Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ showModal: false, actionUrl: '' }">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Data Pendaftar Trial</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">← Kembali ke Dashboard</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anak</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orang Tua</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal Trial</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($trials as $trial)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $trial->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $trial->child_name }}</div>
                            <div class="text-sm text-gray-500">{{ $trial->child_age }} Tahun</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $trial->parent_name }}</div>
                            <div class="text-sm text-gray-500">{{ $trial->phone }}</div>
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $trial->phone) }}" target="_blank" class="text-green-600 hover:text-green-800 text-xs font-bold inline-flex items-center mt-1">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg> Chat
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($trial->scheduled_at)
                                <div class="text-indigo-600 font-semibold">{{ $trial->scheduled_at->format('d M Y') }}</div>
                                <div class="text-xs">{{ $trial->scheduled_at->format('H:i') }} WIB</div>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $trial->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $trial->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $trial->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $trial->status === 'registered' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ ucfirst($trial->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button type="button" 
                                    @click="showModal = true; actionUrl = '{{ route('admin.trials.update', $trial) }}'"
                                    class="text-xs bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full border border-indigo-200 hover:bg-indigo-100">
                                    Jadwal
                                </button>
                                <form action="{{ route('admin.trials.update', $trial) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-full border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="pending" {{ $trial->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="scheduled" {{ $trial->status == 'scheduled' ? 'selected' : '' }}>Dijadwalkan</option>
                                        <option value="completed" {{ $trial->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="registered" {{ $trial->status == 'registered' ? 'selected' : '' }}>Sudah Daftar</option>
                                    </select>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data pendaftar trial.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scheduling Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showModal = false">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form :action="actionUrl" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Atur Jadwal Trial
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">
                                        Pilih tanggal dan jam pelaksanaan trial untuk siswa ini.
                                    </p>
                                    
                                    <input type="hidden" name="status" value="scheduled">
                                    
                                    <div>
                                        <label for="scheduled_at" class="block text-sm font-medium text-gray-700">Waktu Trial</label>
                                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" required
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan Jadwal
                        </button>
                        <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
