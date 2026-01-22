@extends('errors::layout')

@section('code', '403')

@section('title', 'Akses Ditolak')

@section('icon')
    <svg class="w-24 h-24 md:w-32 md:h-32 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
        <circle cx="12" cy="12" r="9" stroke-width="1.5" />
    </svg>
@endsection

@section('message')
    @if (isset($exception) && $exception->getMessage())
        {{ $exception->getMessage() }}
    @else
        Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Jika Anda merasa ini adalah kesalahan, silakan hubungi
        administrator.
    @endif
@endsection

@section('additional')
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-sm text-red-700">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd" />
            </svg>
            <div>
                <p class="font-semibold mb-1">Akses Terbatas</p>
                <p class="text-xs">Halaman ini hanya dapat diakses oleh pengguna dengan hak akses tertentu.</p>
            </div>
        </div>
    </div>
@endsection
