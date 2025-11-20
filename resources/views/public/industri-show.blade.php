@php
    $title = 'Detail Industri Prakerin';
@endphp
@extends('layouts.public')

@section('content')
    <section class="mb-6"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 100)"
             x-show="show"
             x-transition.opacity.duration.500ms
             x-transition.transform.origin-top.duration.500ms>
        <a href="{{ route('public.industri') }}" class="text-xs text-primary hover:underline">&larr; Kembali ke daftar industri</a>
    </section>

    <section class="mb-6 flex flex-col md:flex-row md:items-start md:gap-6"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 150)"
             x-show="show"
             x-transition.opacity.duration.500ms
             x-transition.transform.origin-top.duration.500ms>
        <div class="mb-4 md:mb-0 md:w-48">
            @if (!empty($industri->foto))
                <div class="w-40 h-40 rounded-xl bg-white border border-slate-200 shadow-sm overflow-hidden flex items-center justify-center">
                    <img src="{{ asset($industri->foto) }}" alt="Foto {{ $industri->nama_industri }}" class="max-w-full max-h-full object-cover">
                </div>
            @else
                <div class="w-40 h-40 rounded-xl bg-primary/5 border border-primary/20 flex items-center justify-center text-xs text-primary font-semibold">
                    {{ $industri->nama_industri }}
                </div>
            @endif
        </div>

        <div class="flex-1 text-sm">
            <h1 class="text-2xl font-bold text-slate-900 mb-1">{{ $industri->nama_industri }}</h1>
            @if ($industri->bidang_kerja)
                <p class="text-slate-600 mb-2">Bidang kerja: <span class="font-medium">{{ $industri->bidang_kerja }}</span></p>
            @endif

            <div class="grid md:grid-cols-2 gap-4 text-xs mt-3">
                <div class="space-y-1">
                    <h2 class="font-semibold text-slate-900 mb-1">Alamat</h2>
                    @if ($industri->alamat_industri)
                        <p class="text-slate-600">{{ $industri->alamat_industri }}</p>
                    @endif
                    @if ($industri->wilayah)
                        <p class="text-slate-600">Wilayah: {{ $industri->wilayah }}</p>
                    @endif
                </div>
                <div class="space-y-1">
                    <h2 class="font-semibold text-slate-900 mb-1">Kontak & Kuota</h2>
                    @if ($industri->telepon)
                        <p class="text-slate-600">Telepon: {{ $industri->telepon }}</p>
                    @endif
                    @if (!is_null($industri->kuota))
                        <p class="text-slate-600">Perkiraan kuota siswa: {{ $industri->kuota }}</p>
                    @endif
                    <p class="text-slate-600">Total siswa yang pernah / sedang Prakerin: {{ $industri->tempat_count ?? 0 }} siswa</p>
                </div>
            </div>
        </div>
    </section>

    @if ($industri->deskripsi)
        <section class="bg-white border border-slate-100 rounded-xl p-5 text-xs leading-relaxed text-slate-700 mb-4">
            <h2 class="font-semibold text-slate-900 mb-2">Deskripsi Industri</h2>
            {!! nl2br(e($industri->deskripsi)) !!}
        </section>
    @endif

    @if (!empty($activeYear) && !empty($rekapPerJurusan))
        <section class="bg-white border border-slate-100 rounded-xl p-5 text-xs text-slate-700">
            <div class="flex items-center justify-between mb-3">
                <h2 class="font-semibold text-slate-900">Rekap Siswa PKL per Jurusan</h2>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-primary/5 text-primary text-[11px] font-medium">
                    Tahun PKL {{ $activeYear }}
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-[11px]">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-500">
                            <th class="py-2 pr-4">Jurusan</th>
                            <th class="py-2 pr-4">Aktif</th>
                            <th class="py-2 pr-4">Selesai</th>
                            <th class="py-2 pr-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rekapPerJurusan as $jurusan => $data)
                            <tr class="border-b border-slate-100 last:border-0">
                                <td class="py-1.5 pr-4">{{ $jurusan }}</td>
                                <td class="py-1.5 pr-4">{{ $data['active'] }} siswa</td>
                                <td class="py-1.5 pr-4">{{ $data['done'] }} siswa</td>
                                <td class="py-1.5 pr-4">{{ $data['total'] }} siswa</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif
@endsection
