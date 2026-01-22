@extends('layouts.app')

@section('title', 'Lab Sessions')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Lab Sessions</h1>
    <p class="text-gray-600 mt-1">Virtual programming lab untuk praktikum coding</p>
</div>

{{-- Created Labs Section --}}
@if($createdLabs->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Lab yang Saya Buat
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($createdLabs as $lab)
        <div class="card hover:shadow-lg transition-shadow border-l-4 border-l-indigo-500">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $lab->judul }}</h3>
                    <p class="text-sm text-gray-600">{{ $lab->kelas->nama }}</p>
                </div>
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800 uppercase">
                    {{ $lab->bahasa_pemrograman }}
                </span>
            </div>

            @if($lab->deskripsi)
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $lab->deskripsi }}</p>
            @endif

            <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                @if($lab->deadline)
                    <span>Deadline: {{ $lab->deadline->format('d M Y, H:i') }}</span>
                @else
                    <span>No deadline</span>
                @endif
            </div>

            <div class="flex gap-2">
                <a href="{{ route('lab.show', $lab->id) }}" class="btn-primary flex-1 text-center text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Lihat
                </a>
                <a href="{{ route('lab.submissions', $lab->id) }}" class="btn-outline flex-1 text-center text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Submissions
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Joined Labs Section --}}
@if($joinedLabs->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
        Lab dari Kelas yang Diikuti
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($joinedLabs as $lab)
        <div class="card hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $lab->judul }}</h3>
                    <p class="text-sm text-gray-600">{{ $lab->kelas->nama }}</p>
                </div>
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800 uppercase">
                    {{ $lab->bahasa_pemrograman }}
                </span>
            </div>

            @if($lab->deskripsi)
            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $lab->deskripsi }}</p>
            @endif

            <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                @if($lab->deadline)
                    <span>Deadline: {{ $lab->deadline->format('d M Y, H:i') }}</span>
                @else
                    <span>No deadline</span>
                @endif
            </div>

            @php
                $userSubmission = $lab->submissions->first();
            @endphp

            @if($userSubmission)
                <div class="mb-4 p-3 rounded-lg {{ $userSubmission->status === 'passed' ? 'bg-green-50' : 'bg-gray-50' }}">
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-medium">Status:</span>
                        <span class="flex items-center gap-1 font-semibold {{ $userSubmission->status === 'passed' ? 'text-green-700' : 'text-gray-700' }}">
                            @if($userSubmission->status === 'passed')
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Passed ({{ $userSubmission->score }})
                            @else
                                {{ ucfirst($userSubmission->status) }}
                            @endif
                        </span>
                    </div>
                </div>
            @else
                <div class="mb-4 p-3 rounded-lg bg-yellow-50">
                    <span class="text-sm text-yellow-700 font-medium">Belum dikerjakan</span>
                </div>
            @endif

            <a href="{{ route('lab.show', $lab->id) }}" class="btn-primary w-full text-center block">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                </svg>
                {{ $userSubmission ? 'Continue Coding' : 'Start Coding' }}
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Empty State --}}
@if($createdLabs->count() == 0 && $joinedLabs->count() == 0)
    <div class="card text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Lab Session</h3>
        <p class="text-gray-600">Lab session akan muncul ketika instruktur membuat praktikum baru</p>
    </div>
@endif
@endsection
