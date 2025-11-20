@php
    $title = 'Detail Info Prakerin';
@endphp
@extends('layouts.public')

@section('content')
    <section class="mb-4 text-xs">
        <a href="{{ route('public.info') }}" class="text-primary hover:underline">&larr; Kembali ke daftar info</a>
    </section>

    <section class="bg-white border border-slate-100 rounded-xl p-5 text-xs leading-relaxed text-slate-700 mb-4">
        <div class="flex items-start justify-between gap-3 mb-2">
            <div>
                <div class="text-[11px] text-slate-400 mb-1">
                    {{ $info->tanggal?->format('d M Y') ?? $info->created_at?->format('d M Y') }}
                    @if ($info->kategori)
                        · <span class="text-primary">{{ $info->kategori }}</span>
                    @endif
                </div>
                <h1 class="text-base md:text-lg font-semibold text-slate-900">
                    {{ $info->judul }}
                </h1>
            </div>
        </div>

        <div class="mt-3">
            {!! nl2br(e($info->isi)) !!}
        </div>

        @if ($info->file)
            @php
                $lampiranUrl = asset('storage/'.$info->file);
                $ext = strtolower(pathinfo($info->file, PATHINFO_EXTENSION));
            @endphp

            <div class="mt-5 border-t border-slate-100 pt-4">
                <h2 class="font-semibold mb-2 text-slate-900">Lampiran</h2>

                {{-- Tombol Unduh --}}
                <a href="{{ $lampiranUrl }}" target="_blank"
                   class="inline-flex items-center px-3 py-1.5 rounded-full border border-primary text-primary hover:bg-primary/5">
                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M16 12l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Unduh Lampiran
                </a>

                {{-- Preview Lampiran --}}
                @if (in_array($ext, ['jpg','jpeg','png','gif','webp']))
                    <div class="mt-4">
                        <img src="{{ $lampiranUrl }}" alt="Lampiran"
                             class="max-w-full rounded-md shadow-sm">
                    </div>
                @elseif ($ext === 'pdf')
                    <div class="mt-4">
                        <iframe src="{{ $lampiranUrl }}" class="w-full h-96 border rounded-md"
                                title="Lampiran PDF"></iframe>
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection