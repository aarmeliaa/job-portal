<x-app-layout>
    {{-- Bagian Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Lowongan Kerja') }}
        </h2>
    </x-slot>

    {{-- Bagian Konten Utama ($slot) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Menampilkan Pesan Sukses --}}
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- AREA KHUSUS ADMIN --}}
                    @if(Auth::user()->role === 'admin')
                        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 p-4 bg-gray-50 border rounded-lg">
                            
                            {{-- KIRI: Tombol Navigasi Admin --}}
                            <div class="flex gap-2">
                                {{-- TOMBOL BARU: Lihat Pelamar --}}
                                <a href="{{ route('applications.index') }}">
                                    <x-secondary-button class="bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100">
                                        📋 {{ __('Lihat Pelamar Masuk') }}
                                    </x-secondary-button>
                                </a>

                                {{-- Tombol Tambah Lowongan --}}
                                <a href="{{ route('jobs.create') }}">
                                    <x-primary-button>
                                        {{ __('+ Tambah Lowongan') }}
                                    </x-primary-button>
                                </a>
                            </div>

                            {{-- KANAN: Import Excel --}}
                            <div class="w-full md:w-auto">
                                <form action="{{ route('jobs.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                                    @csrf
                                    <input type="file" name="file" class="block w-full text-xs text-gray-500 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200" required>
                                    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 text-xs">
                                        Import Excel
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    
                    {{-- Tabel Daftar Lowongan --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Judul</th>
                                    <th scope="col" class="px-6 py-3">Perusahaan</th>
                                    <th scope="col" class="px-6 py-3">Lokasi</th>
                                    <th scope="col" class="px-6 py-3">Gaji</th>
                                    <th scope="col" class="px-6 py-3">Logo</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $job)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a href="{{ route('jobs.show', $job->id) }}" class="hover:text-indigo-500 hover:underline">
                                            {{ $job->title }}
                                        </a>
                                    </th>
                                    <td class="px-6 py-4">{{ $job->company }}</td>
                                    <td class="px-6 py-4">{{ $job->location }}</td>
                                    <td class="px-6 py-4">Rp{{ number_format($job->salary, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        @if($job->logo)
                                            <img src="{{ asset('storage/' . $job->logo) }}" alt="Logo" class="w-12 h-12 object-contain rounded bg-gray-50 p-1 border"> 
                                        @else
                                            <span class="text-xs text-gray-400">No Logo</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        
                                        @if(Auth::user()->is_admin)
                                            {{-- Admin: Edit & Hapus --}}
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('jobs.edit', $job->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Hapus lowongan ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                                </form>
                                            </div>
                                        @else
                                            {{-- User Biasa: Lamar --}}
                                            <form action="{{ route('apply.store', $job->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-2">
                                                @csrf
                                                <input type="file" name="cv" class="block w-full text-xs text-gray-900 border border-gray-300 rounded cursor-pointer bg-gray-50 focus:outline-none" required>
                                                <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-xs px-3 py-1.5 dark:bg-indigo-600 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                                                    Lamar Sekarang
                                                </button>
                                            </form>
                                        @endif

                                    </td>
                                </tr>
                                @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data lowongan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>