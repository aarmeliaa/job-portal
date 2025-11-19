<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Lowongan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Menampilkan Pesan Sukses/Error --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Header Detail Lowongan --}}
                    @if($job->logo)
                    <div class="text-center mb-6">
                        <img src="{{ asset('storage/' . $job->logo) }}" alt="Logo {{ $job->company }}" class="w-32 h-32 object-contain mx-auto rounded-lg shadow-md border dark:border-gray-700 p-2">
                    </div>
                    @endif

                    <h1 class="text-3xl font-bold text-center mb-2">{{ $job->title }}</h1>
                    <p class="text-xl text-center text-indigo-500 mb-6">{{ $job->company }}</p>

                    {{-- Info Lokasi & Gaji --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-8 border-t border-b py-4 dark:border-gray-700">
                        <div class="flex items-center justify-center md:justify-start">
                            <span class="font-semibold mr-2">{{ __('Lokasi:') }}</span> {{ $job->location }}
                        </div>
                        <div class="flex items-center justify-center md:justify-start">
                            <span class="font-semibold mr-2">{{ __('Gaji:') }}</span> Rp{{ number_format($job->salary, 0, ',', '.') }} / Bulan
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <h3 class="text-xl font-semibold mb-3 border-b pb-2 dark:border-gray-700">{{ __('Deskripsi Pekerjaan') }}</h3>
                    <div class="prose dark:prose-invert max-w-none mb-8">
                        <p>{!! nl2br(e($job->description)) !!}</p>
                    </div>

                    {{-- AREA FORMULIR LAMARAN KERJA --}}
                    {{-- Logic: Hanya muncul jika user BUKAN Admin --}}
                    @if(Auth::user() && !Auth::user()->is_admin) 
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600 mt-8">
                            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-white">Tertarik melamar posisi ini?</h3>
                            
                            <form action="{{ route('apply.store', $job->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="cv" :value="__('Upload CV Anda (PDF/DOC)')" />
                                    <input id="cv" name="cv" type="file" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-2" required>
                                    <x-input-error class="mt-2" :messages="$errors->get('cv')" />
                                </div>
                                
                                <x-primary-button class="w-full justify-center">
                                    {{ __('Kirim Lamaran') }}
                                </x-primary-button>
                            </form>
                        </div>
                    @elseif(Auth::user() && Auth::user()->is_admin)
                         <div class="mt-8 p-4 bg-yellow-100 text-yellow-800 rounded text-center">
                            Anda login sebagai <strong>Admin</strong>. Admin tidak dapat melamar pekerjaan.
                        </div>
                    @endif

                    {{-- Tombol Kembali --}}
                    <div class="mt-8 pt-4 border-t dark:border-gray-700">
                        <a href="{{ route('jobs.index') }}">
                            <x-secondary-button>
                                {{ __('Kembali ke Daftar Lowongan') }}
                            </x-secondary-button>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>