@php
    $title = 'Info PKL';
@endphp
@extends('layouts.public')

@section('content')
    <section class="mb-6"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 100)"
             x-show="show"
             x-transition.opacity.duration.500ms
             x-transition.transform.origin-top.duration.500ms>
        <h1 class="text-2xl font-bold text-slate-900 mb-1">Info & Pengumuman PKL</h1>
        <p class="text-sm text-slate-600">Pengumuman resmi terkait pelaksanaan Praktik Kerja Lapangan.</p>
    </section>

    @if (!empty($availableCategories) || !empty($availableYears))
        <section class="bg-white rounded-xl border border-slate-100 p-4 mb-4 text-xs"
                 x-data="{ show: false }"
                 x-init="setTimeout(() => show = true, 100)"
                 x-show="show"
                 x-transition.opacity.duration.500ms
                 x-transition.transform.origin-top.duration.500ms>
            <form method="GET" action="{{ route('public.info') }}" class="grid sm:grid-cols-4 gap-3 items-end">
                <div class="sm:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Cari info</label>
                    <input type="text"
                           name="q"
                           value="{{ request('q') }}"
                           placeholder="Judul atau isi pengumuman"
                           class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-xs
                                  focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Kategori</label>
                    <select name="kategori"
                            class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-xs
                                   focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                        <option value="">Semua kategori</option>
                        @foreach ($availableCategories as $kategori)
                            <option value="{{ $kategori }}" @selected(request('kategori') === $kategori)>
                                {{ $kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Tahun</label>
                    <select name="tahun"
                            class="w-full border border-slate-200 rounded-lg px-3 py-1.5 text-xs
                                   focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary">
                        <option value="">Semua tahun</option>
                        @foreach ($availableYears as $year)
                            <option value="{{ $year }}" @selected((string) request('tahun') === (string) $year)>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit"
                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-primary text-white
                                   font-semibold text-[11px] hover:bg-primary/90">
                        Terapkan Filter
                    </button>
                    @if (request()->hasAny(['q', 'kategori', 'tahun']))
                        <a href="{{ route('public.info') }}"
                           class="inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-200
                                  text-[11px] text-slate-700 hover:bg-slate-50">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </section>
    @endif

    @if ($infos->isEmpty())
        <p class="text-xs text-slate-500">Belum ada info PKL yang dipublikasikan.</p>
    @else
        <div class="space-y-3 text-xs">
            @foreach ($infos as $info)
                <article class="bg-white border border-slate-100 rounded-xl p-4 flex flex-col justify-between gap-2">
                    <div>
                        <div class="text-[11px] text-slate-400 mb-1">
                            {{ $info->tanggal?->format('d M Y') ?? $info->created_at?->format('d M Y') }}
                            @if ($info->kategori)
                                &middot; <span class="text-primary">{{ $info->kategori }}</span>
                            @endif
                        </div>
                        <h2 class="font-semibold text-slate-900 mb-1 text-sm">
                            <a href="{{ route('public.info.show', $info) }}" class="hover:text-primary">
                                {{ $info->judul ?? $info->title }}
                            </a>
                        </h2>
                        @if (!empty($info->isi))
                            <p class="text-[11px] text-slate-700 line-clamp-2">
                                {{ Str::limit(strip_tags($info->isi), 150) }}
                            </p>
                        @endif
                    </div>
                    <div class="text-right">
                        <a href="{{ route('public.info.show', $info) }}"
                           class="text-[11px] text-primary hover:underline">
                            Detail &rarr;
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-4 text-xs">
            {{ $infos->links() }}
        </div>
    @endif
@endsection