<x-app-layout>
    {{-- Bagian Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Lowongan') }}
        </h2>
    </x-slot>

    {{-- Bagian Konten Utama ($slot) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Form Tambah Lowongan --}}
                    <form action="{{ route('jobs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf 
                        
                        {{-- Judul Lowongan --}}
                        <div>
                            <x-input-label for="title" :value="__('Judul Lowongan')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="Judul Lowongan" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" placeholder="Deskripsi pekerjaan" required></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        {{-- Lokasi --}}
                        <div>
                            <x-input-label for="location" :value="__('Lokasi')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" placeholder="Lokasi" required />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                        {{-- Nama Perusahaan --}}
                        <div>
                            <x-input-label for="company" :value="__('Nama Perusahaan')" />
                            <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" placeholder="Nama Perusahaan" required />
                            <x-input-error class="mt-2" :messages="$errors->get('company')" />
                        </div>

                        {{-- Gaji --}}
                        <div>
                            <x-input-label for="salary" :value="__('Gaji (IDR)')" />
                            <x-text-input id="salary" name="salary" type="number" class="mt-1 block w-full" placeholder="Gaji" required min="0" />
                            <x-input-error class="mt-2" :messages="$errors->get('salary')" />
                        </div>

                        {{-- Logo --}}
                        <div>
                            <x-input-label for="logo" :value="__('Logo Perusahaan')" />
                            {{-- Menggunakan input file standar karena x-text-input tidak cocok untuk file --}}
                            <input id="logo" name="logo" type="file" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-violet-50 file:text-violet-700
                                hover:file:bg-violet-100" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">PNG, JPG, atau JPEG (Maks. 2MB).</p>
                            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="flex items-center gap-4">
                            <x-primary-button>
                                {{ __('Simpan Lowongan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>