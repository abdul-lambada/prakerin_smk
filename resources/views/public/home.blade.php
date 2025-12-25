@php
    $title = 'Beranda';
@endphp
@extends('layouts.public')

@section('content')
    <section class="grid md:grid-cols-2 gap-10 items-center mb-12" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)"
        x-show="show" x-transition.opacity.duration.500ms x-transition.transform.origin-top.duration.500ms>
        <div>
            <p class="text-xs font-semibold tracking-wide text-primary uppercase mb-2">
                {{ \Illuminate\Support\Str::upper($settings['app_name'] ?? 'Sistem Informasi Prakerin') }}</p>
            <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">
                Prakerin {{ $settings['school_name'] ?? 'SMK' }} secara terpadu.
            </h1>
            <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                Portal ini digunakan oleh siswa, pembimbing sekolah, dan mitra industri untuk mengelola penempatan Praktik
                Kerja Lapangan (Prakerin), absensi, jurnal harian, penilaian, hingga laporan akhir.
            </p>

            <div class="flex flex-wrap gap-3 mb-6 text-xs">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center px-4 py-2 rounded-full bg-primary text-white font-semibold shadow-sm hover:bg-primary/90">
                    Masuk ke Sistem
                </a>
                <a href="{{ route('register.dudi') }}"
                    class="inline-flex items-center px-4 py-2 rounded-full border border-slate-200 text-slate-700 hover:bg-slate-50">
                    Registrasi Mitra DUDI
                </a>
            </div>

            <ul class="grid grid-cols-2 gap-3 text-xs text-slate-700">
                <li class="flex items-start gap-2">
                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-primary"></span>
                    <span>Penempatan Prakerin terdata rapi per industri.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-primary"></span>
                    <span>Absensi & jurnal harian tercatat secara digital.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-primary"></span>
                    <span>Penilaian DUDI & sekolah terintegrasi.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="mt-1 w-1.5 h-1.5 rounded-full bg-primary"></span>
                    <span>Laporan PKL siap cetak sesuai format sekolah.</span>
                </li>
            </ul>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 md:p-6" x-data="{
            index: 0,
            total: {{ $industries->count() }},
            next() { if (this.total > 0) this.index = (this.index + 1) % this.total },
            prev() { if (this.total > 0) this.index = (this.index - 1 + this.total) % this.total },
        }"
            x-init="if (total > 1) { setInterval(() => next(), 5000); }">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-900">Ringkasan Mitra Industri</h2>
                @if (!$industries->isEmpty())
                    <div class="flex items-center gap-2 text-[11px] text-slate-500">
                        <button type="button" @click="prev()"
                            class="w-6 h-6 flex items-center justify-center rounded-full border border-slate-200 hover:bg-slate-50">
                            <span>&larr;</span>
                        </button>
                        <button type="button" @click="next()"
                            class="w-6 h-6 flex items-center justify-center rounded-full border border-slate-200 hover:bg-slate-50">
                            <span>&rarr;</span>
                        </button>
                    </div>
                @endif
            </div>

            @if ($industries->isEmpty())
                <p class="text-xs text-slate-500">Belum ada data industri yang terdaftar.</p>
            @else
                <div class="text-xs">
                    @foreach ($industries as $i => $industri)
                        <div x-show="index === {{ $i }}" x-cloak
                            class="border border-slate-100 rounded-lg px-3 py-3 flex items-start justify-between gap-3 min-h-[70px]">
                            <div>
                                <div class="font-semibold text-slate-900 text-xs">
                                    {{ $industri->nama_industri ?? ($industri->nama ?? 'Industri') }}</div>
                                @if (!empty($industri->bidang_kerja))
                                    <div class="text-[11px] text-slate-500">{{ $industri->bidang_kerja }}</div>
                                @endif
                                @if (!empty($industri->alamat_industri))
                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $industri->alamat_industri }}</div>
                                @endif
                            </div>
                            @if (!empty($industri->wilayah))
                                <span
                                    class="text-[11px] px-2 py-1 rounded-full bg-primary/5 text-primary font-medium">{{ $industri->wilayah }}</span>
                            @endif
                        </div>
                    @endforeach

                    <div class="mt-2 flex items-center justify-between text-[11px] text-slate-500">
                        <div>
                            <span x-text="(index + 1) + ' / ' + total"></span>
                        </div>
                        <a href="{{ route('public.industri') }}" class="text-primary hover:underline">Lihat semua industri
                            &rarr;</a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="mb-10" x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)" x-show="show"
        x-transition.opacity.duration.500ms x-transition.transform.origin-top.duration.500ms>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-sm font-semibold text-slate-900">Info & Pengumuman PKL Terbaru</h2>
            <a href="{{ route('public.info') }}" class="text-xs text-primary hover:underline">Lihat semua</a>
        </div>

        @if ($infos->isEmpty())
            <p class="text-xs text-slate-500">Belum ada info PKL yang dipublikasikan.</p>
        @else
            <div class="grid md:grid-cols-2 gap-4 text-xs">
                @foreach ($infos as $info)
                    <article class="bg-white border border-slate-100 rounded-xl p-4 flex flex-col justify-between">
                        <div>
                            <div class="text-[11px] text-slate-400 mb-1">{{ $info->created_at?->format('d M Y') }}</div>
                            <h3 class="font-semibold text-slate-900 mb-1 line-clamp-2">{{ $info->judul ?? $info->title }}
                            </h3>
                            @if (!empty($info->isi))
                                <p class="text-[11px] text-slate-600 line-clamp-3">{{ strip_tags($info->isi) }}</p>
                            @endif
                        </div>
                        <div class="mt-3 text-right">
                            <a href="{{ route('public.info') }}"
                                class="text-[11px] text-primary hover:underline">Selengkapnya</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
@endsection
