<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Pelamar Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Tombol Export Excel (Nanti kita fungsikan) --}}
                    <div class="mb-4 flex justify-end">
                        <a href="{{ route('applications.export') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                            Export ke Excel
                        </a>
                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Nama Pelamar</th>
                                    <th class="px-6 py-3">Posisi Lowongan</th>
                                    <th class="px-6 py-3">Tanggal Melamar</th>
                                    <th class="px-6 py-3">CV</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $app)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $app->user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $app->job->title }} <br>
                                        <span class="text-xs text-gray-500">{{ $app->job->company }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $app->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Tombol Lihat CV --}}
                                        <a href="{{ asset('storage/' . $app->cv) }}" target="_blank" class="text-blue-600 hover:underline">
                                            Lihat PDF
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($app->status == 'Pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending</span>
                                        @elseif($app->status == 'Accepted')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Diterima</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 flex justify-center gap-2">
                                        {{-- Form Terima --}}
                                        <form action="{{ route('applications.update', $app->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="Accepted">
                                            <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700">
                                                Terima
                                            </button>
                                        </form>

                                        {{-- Form Tolak --}}
                                        <form action="{{ route('applications.update', $app->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="Rejected">
                                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
                                                Tolak
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center">Belum ada pelamar masuk.</td>
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