@extends('errors::layout')

@section('code', '500')

@section('title', 'Terjadi Kesalahan Server')

@section('icon')
    <svg class="w-24 h-24 md:w-32 md:h-32 mx-auto text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
    </svg>
@endsection

@section('message')
    Oops! Terjadi kesalahan pada server kami. Tim kami telah diberitahu dan sedang bekerja untuk memperbaikinya. Silakan
    coba lagi dalam beberapa saat.
@endsection

@section('additional')
    <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-orange-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <div class="text-sm text-orange-800">
                <p class="font-semibold mb-1">Kesalahan Sementara</p>
                <p class="text-xs">Jika masalah berlanjut, silakan hubungi tim support kami dengan menyertakan kode error:
                    <span class="font-mono bg-orange-100 px-2 py-0.5 rounded">500</span></p>
            </div>
        </div>
    </div>
@endsection
