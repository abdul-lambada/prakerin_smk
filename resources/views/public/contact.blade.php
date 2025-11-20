@php
    $title = 'Kontak';
@endphp
@extends('layouts.public')

@section('content')
    <section class="mb-8 flex flex-col md:flex-row md:items-center md:gap-6"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 100)"
             x-show="show"
             x-transition.opacity.duration.500ms
             x-transition.transform.origin-top.duration.500ms>
        <div class="mb-4 md:mb-0 md:w-40 flex justify-center">
            @if (!empty($settings['app_logo']))
                <div class="w-24 h-24 md:w-28 md:h-28 rounded-full border border-slate-200 bg-white shadow-sm flex items-center justify-center overflow-hidden">
                    <img src="{{ asset($settings['app_logo']) }}" alt="Logo" class="max-w-full max-h-full object-contain">
                </div>
            @else
                <div class="w-24 h-24 md:w-28 md:h-28 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="text-primary font-bold">PKL</span>
                </div>
            @endif
        </div>

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900 mb-2">Kontak</h1>
            <p class="text-sm text-slate-600 max-w-2xl">
                Silakan hubungi sekolah atau koordinator PKL jika membutuhkan informasi lebih lanjut terkait pelaksanaan Praktik Kerja Lapangan.
            </p>
        </div>
    </section>

    <section class="grid md:grid-cols-2 gap-6 text-xs mb-10"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 150)"
             x-show="show"
             x-transition.opacity.duration.500ms
             x-transition.transform.origin-top.duration.500ms>
        <div class="bg-white border border-slate-100 rounded-xl p-5 space-y-2">
            <h2 class="font-semibold text-slate-900 mb-2">Informasi Sekolah</h2>
            <p class="text-slate-700"><span class="font-medium">{{ $settings['school_name'] ?? 'SMK' }}</span></p>
            @if (!empty($settings['school_address']))
                <p class="text-slate-600">{{ $settings['school_address'] }}</p>
            @endif
            <div class="space-y-1 text-slate-600">
                @if (!empty($settings['school_phone']))
                    <p>Telp: {{ $settings['school_phone'] }}</p>
                @endif
                @if (!empty($settings['school_email']))
                    <p>Email: {{ $settings['school_email'] }}</p>
                @endif
                @if (!empty($settings['school_city']))
                    <p>Kota/Kabupaten: {{ $settings['school_city'] }}</p>
                @endif
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-xl p-5 space-y-2">
            <h2 class="font-semibold text-slate-900 mb-2">Kontak Koordinator PKL</h2>
            <p class="text-slate-700">
                @if (!empty($settings['pkl_coordinator_name']))
                    <span class="font-medium">{{ $settings['pkl_coordinator_name'] }}</span>
                @else
                    <span class="font-medium">Koordinator PKL</span>
                @endif
            </p>
            @if (!empty($settings['pkl_coordinator_nip']))
                <p class="text-slate-600">NIP: {{ $settings['pkl_coordinator_nip'] }}</p>
            @endif
            <p class="text-[11px] text-slate-500 mt-2">
                Detail kontak koordinator PKL dapat ditanyakan melalui tata usaha atau humas sekolah.
            </p>
        </div>
    </section>
@endsection
