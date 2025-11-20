@php
    $title = 'Daftar Industri PKL';
@endphp
@extends('layouts.public')

@section('content')
    <section class="mb-6"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 100)"
             x-show="show"
             x-transition.opacity.duration.500ms
             x-transition.transform.origin-top.duration.500ms>
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Daftar Industri PKL</h1>
        <p class="text-sm text-slate-600">Mitra industri yang bekerja sama dengan {{ $settings['school_name'] ?? 'sekolah' }} untuk pelaksanaan PKL.</p>
    </section>

    <section class="text-xs"
             x-data="{ q: '', wilayah: '', show: false }"
             x-init="setTimeout(() => show = true, 150)"
             x-show="show"
             x-transition.opacity.duration.500ms>
        <div class="bg-white rounded-xl border border-slate-100 p-4 mb-4 flex flex-col md:flex-row md:items-end gap-3">
            <div class="flex-1">
                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Cari industri</label>
                <input type="text" x-model="q" placeholder="Nama industri / bidang usaha" class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
            </div>
            <div class="w-full md:w-48">
                <label class="block text-[11px] font-semibold text-slate-500 mb-1">Filter wilayah (opsional)</label>
                <input type="text" x-model="wilayah" placeholder="Kota / kabupaten" class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
            </div>
        </div>

        @if ($industries->isEmpty())
            <p class="text-slate-500">Belum ada data industri.</p>
        @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
                @foreach ($industries as $industri)
                    @php
                        $name = $industri->nama_industri ?? '-';
                        $bidang = $industri->bidang_kerja ?? '';
                        $alamat = $industri->alamat_industri ?? '';
                        $wilayah = $industri->wilayah ?? '';
                        $telepon = $industri->telepon ?? '';
                        $kuota = $industri->kuota;
                        $tempatCount = $industri->tempat_count ?? 0;
                    @endphp
                    <article
                        class="bg-white border border-slate-100 rounded-xl p-4 flex flex-col justify-between"
                        x-show="(q === '' || '{{ Str::lower($name . ' ' . $bidang) }}'.includes(q.toLowerCase())) && (wilayah === '' || '{{ Str::lower($wilayah) }}'.includes(wilayah.toLowerCase()))"
                        x-cloak
                    >
                        <div class="space-y-1">
                            <h2 class="font-semibold text-slate-900 mb-1 text-sm">
                                <a href="{{ route('public.industri.show', $industri) }}" class="hover:text-primary">
                                    {{ $name }}
                                </a>
                            </h2>
                            @if ($bidang)
                                <p class="text-[11px] text-slate-500">Bidang kerja: {{ $bidang }}</p>
                            @endif
                            @if ($alamat)
                                <p class="text-[11px] text-slate-500">{{ $alamat }}</p>
                            @endif
                            @if ($wilayah)
                                <p class="text-[11px] text-slate-500">Wilayah: {{ $wilayah }}</p>
                            @endif
                            @if ($telepon)
                                <p class="text-[11px] text-slate-500">Telp: {{ $telepon }}</p>
                            @endif
                            @if (!is_null($kuota))
                                <p class="text-[11px] text-slate-500">Perkiraan kuota: {{ $kuota }} siswa</p>
                            @endif
                            <p class="text-[11px] text-slate-500">Siswa ditempatkan: {{ $tempatCount }} siswa</p>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-[11px]">
                            @if ($wilayah)
                                <span class="inline-flex px-2 py-1 rounded-full bg-primary/5 text-primary font-medium">{{ $wilayah }}</span>
                            @else
                                <span></span>
                            @endif
                            <a href="{{ route('public.industri.show', $industri) }}" class="text-primary hover:underline">Detail &rarr;</a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="text-xs">
                {{ $industries->links() }}
            </div>
        @endif
    </section>
@endsection
