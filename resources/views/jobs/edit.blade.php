<x-app-layout>
    {{-- Bagian Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Lowongan: ') . $job->title }}
        </h2>
    </x-slot>

    {{-- Bagian Konten Utama ($slot) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Form Edit Lowongan. Menggunakan metode POST dengan directive @method('PUT') --}}
                    <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf 
                        @method('PUT') 
                        
                        {{-- Judul Lowongan --}}
                        <div>
                            <x-input-label for="title" :value="__('Judul Lowongan')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="Judul Lowongan" value="{{ old('title', $job->title) }}" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full" placeholder="Deskripsi pekerjaan" required>{{ old('description', $job->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        {{-- Lokasi --}}
                        <div>
                            <x-input-label for="location" :value="__('Lokasi')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" placeholder="Lokasi" value="{{ old('location', $job->location) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                        {{-- Nama Perusahaan --}}
                        <div>
                            <x-input-label for="company" :value="__('Nama Perusahaan')" />
                            <x-text-input id="company" name="company" type="text" class="mt-1 block w-full" placeholder="Nama Perusahaan" value="{{ old('company', $job->company) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('company')" />
                        </div>

                        {{-- Gaji --}}
                        <div>
                            <x-input-label for="salary" :value="__('Gaji (IDR)')" />
                            <x-text-input id="salary" name="salary" type="number" class="mt-1 block w-full" placeholder="Gaji" value="{{ old('salary', $job->salary) }}" required min="0" />
                            <x-input-error class="mt-2" :messages="$errors->get('salary')" />
                        </div>

                        {{-- Logo Saat Ini --}}
                        @if ($job->logo)
                        <div class="mt-4">
                            <x-input-label :value="__('Logo Saat Ini')" />
                            <img src="{{ asset('storage/' . $job->logo) }}" alt="Current Logo" class="mt-2 w-20 h-20 object-contain rounded">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tinggalkan kosong jika tidak ingin diubah.</p>
                        </div>
                        @endif

                        {{-- Logo Baru --}}
                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                            <x-input-label for="logo" :value="__('Ganti Logo (Opsional)')" />
                            <input id="logo" name="logo" type="file" class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-violet-50 file:text-violet-700
                                hover:file:bg-violet-100" />
                            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                        </div>

                        {{-- Tombol Simpan/Batal --}}
                        <div class="flex items-center gap-4 pt-4">
                            <x-primary-button>
                                {{ __('Update Lowongan') }}
                            </x-primary-button>
                            <a href="{{ route('jobs.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>