@extends('layouts.app')

@section('title', 'Submissions - ' . $lab->judul)

@section('content')
<div class="mb-6">
    <a href="{{ route('lab.show', $lab->id) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Lab
    </a>
</div>

<div class="card">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Submissions</h1>
            <p class="text-gray-600">{{ $lab->judul }}</p>
        </div>
        <div class="text-sm bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full font-medium">
            Total: {{ $submissions->count() }} Submissions
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Mahasiswa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Waktu Submit</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider">Score</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($submissions as $submission)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-medium text-slate-900">{{ $submission->mahasiswa->name }}</div>
                        <div class="text-sm text-slate-500">{{ $submission->mahasiswa->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-900">{{ $submission->updated_at->format('d M Y, H:i') }}</div>
                        <div class="text-xs text-slate-500">{{ $submission->updated_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $submission->status === 'passed' ? 'bg-green-100 text-green-800' : 
                               ($submission->status === 'failed' ? 'bg-red-100 text-red-800' : 
                               ($submission->status === 'error' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst($submission->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-indigo-600">{{ $submission->score }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button 
                            @click="$dispatch('open-modal', 'delete-submission-{{ $submission->id }}')"
                            class="text-red-500 hover:text-red-700 transition-colors"
                            title="Hapus Submission"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>

                        {{-- Modal Konfirmasi (Teleported to body) --}}
                        <template x-teleport="body">
                            <div 
                                x-data="{ show: false }"
                                x-on:open-modal.window="if ($event.detail === 'delete-submission-{{ $submission->id }}') show = true"
                                x-on:close-modal.window="show = false"
                                x-on:keydown.escape.window="show = false"
                                x-show="show"
                                class="fixed inset-0 z-[999] overflow-y-auto"
                                style="display: none;"
                            >
                                <div class="flex items-center justify-center min-h-screen px-4 py-6 text-center sm:block sm:p-0">
                                    {{-- Backdrop --}}
                                    <div 
                                        x-show="show" 
                                        x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        class="fixed inset-0 transition-opacity" 
                                        aria-hidden="true"
                                        @click="show = false"
                                    >
                                        <div class="absolute inset-0 bg-gray-500/75 backdrop-blur-sm"></div>
                                    </div>

                                    {{-- Center Hack --}}
                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                    {{-- Modal Content --}}
                                    <div 
                                        x-show="show" 
                                        x-transition:enter="ease-out duration-300"
                                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave="ease-in duration-200"
                                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                        class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-[1000]"
                                    >
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                                    </svg>
                                                </div>
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                                        Hapus Submission?
                                                    </h3>
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-500">
                                                            Apakah Anda yakin ingin menghapus submission milik <strong>{{ $submission->mahasiswa->name }}</strong>? Data yang dihapus tidak dapat dikembalikan.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                                            <form action="{{ route('lab.submissions.destroy', $submission->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Ya, Hapus
                                                </button>
                                            </form>
                                            <button @click="show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Belum ada submission untuk lab ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
