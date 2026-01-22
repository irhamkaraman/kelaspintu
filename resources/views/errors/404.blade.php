@extends('errors::layout')

@section('code', '404')

@section('title', 'Halaman Tidak Ditemukan')

@section('icon')
    <svg class="w-24 h-24 md:w-32 md:h-32 mx-auto text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@endsection

@section('message')
    Ups! Halaman yang Anda cari sepertinya tidak ada. Mungkin sudah dipindahkan atau URL-nya salah ketik. Coba periksa
    kembali atau kembali ke halaman utama.
@endsection

@section('additional')
    <div class="text-left max-w-md mx-auto">
        <p class="text-sm font-semibold text-slate-700 mb-3">Saran untuk Anda:</p>
        <ul class="space-y-2 text-sm text-slate-600">
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>Periksa kembali URL yang Anda masukkan</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>Kembali ke halaman sebelumnya dan coba lagi</span>
            </li>
            <li class="flex items-start gap-2">
                <svg class="w-4 h-4 text-indigo-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span>Gunakan menu navigasi untuk menemukan halaman</span>
            </li>
        </ul>
    </div>
@endsection
