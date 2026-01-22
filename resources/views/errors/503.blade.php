@extends('errors::layout')

@section('code', '503')

@section('title', 'Sedang Dalam Pemeliharaan')

@section('icon')
    <svg class="w-24 h-24 md:w-32 md:h-32 mx-auto text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
@endsection

@section('message')
    Kami sedang melakukan pemeliharaan sistem untuk meningkatkan performa dan pengalaman Anda. Service akan kembali normal
    dalam waktu singkat.
@endsection

@section('additional')
    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 border border-purple-200 rounded-lg p-6">
        <div class="text-center">
            <p class="text-sm font-semibold text-purple-900 mb-3">Estimasi Waktu Pemulihan</p>
            <div class="flex items-center justify-center gap-2 text-2xl font-bold text-purple-600 mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>~30 Menit</span>
            </div>
            <p class="text-xs text-purple-700">Terakhir diperbarui: {{ now()->format('d M Y, H:i') }} WIB</p>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-center gap-4 text-sm text-slate-600">
        <span>Ikuti update:</span>
        <div class="flex gap-3">
            <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Twitter</a>
            <span class="text-slate-300">•</span>
            <a href="#" class="text-indigo-600 hover:text-indigo-700 font-medium">Status Page</a>
        </div>
    </div>
@endsection
