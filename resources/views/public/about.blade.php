@php
    $title = 'Tentang Prakerin';
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
                <div class="w-28 h-28 md:w-32 md:h-32 rounded-full border border-slate-200 bg-white shadow-sm flex items-center justify-center overflow-hidden">
                    <img src="{{ asset($settings['app_logo']) }}" alt="Logo" class="max-w-full max-h-full object-contain">
                </div>
            @else
                <div class="w-28 h-28 md:w-32 md:h-32 rounded-full bg-primary/10 flex items-center justify-center">
                    <span class="text-primary font-bold text-lg">PR</span>
                </div>
            @endif
        </div>

        <div class="flex-1">
            <h1 class="text-2xl font-bold text-slate-900 mb-2">Tentang Praktik Kerja Lapangan (Prakerin)</h1>
            <p class="text-sm text-slate-600 max-w-3xl leading-relaxed">
            Praktik Kerja Lapangan (Prakerin) adalah kegiatan belajar di dunia kerja yang wajib diikuti oleh peserta didik {{ $settings['school_name'] ?? 'SMK' }}
            untuk mengembangkan kompetensi keahlian, sikap profesional, dan pengalaman nyata di industri.
            </p>
        </div>
    </section>

    <section class="grid md:grid-cols-3 gap-5 text-xs mb-10"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 150)"
             x-show="show"
             x-transition.opacity.duration.500ms
             x-transition.transform.origin-top.duration.500ms>
        <div class="bg-white border border-slate-100 rounded-xl p-4">
            <h2 class="font-semibold text-slate-900 mb-1">Tujuan Prakerin</h2>
            <p class="text-slate-600 leading-relaxed">
                Menghubungkan pembelajaran di sekolah dengan dunia kerja, menumbuhkan etos kerja, dan memberi gambaran nyata tentang lingkungan industri.
            </p>
        </div>
        <div class="bg-white border border-slate-100 rounded-xl p-4">
            <h2 class="font-semibold text-slate-900 mb-1">Manfaat untuk Siswa</h2>
            <ul class="list-disc list-inside text-slate-600 space-y-1">
                <li>Meningkatkan keterampilan teknis sesuai kompetensi keahlian.</li>
                <li>Belajar budaya kerja, disiplin, dan tanggung jawab.</li>
                <li>Menambah pengalaman untuk persiapan dunia kerja.</li>
            </ul>
        </div>
        <div class="bg-white border border-slate-100 rounded-xl p-4">
            <h2 class="font-semibold text-slate-900 mb-1">Peran Mitra Industri</h2>
            <p class="text-slate-600 leading-relaxed">
                Mitra industri menjadi tempat siswa berlatih, memberikan pembimbing lapangan, dan menilai perkembangan kompetensi siswa.
            </p>
        </div>
    </section>

    <section class="bg-white border border-slate-100 rounded-xl p-5 text-xs"
             x-data="{ show: false }"
             x-init="setTimeout(() => show = true, 200)"
             x-show="show"
             x-transition.opacity.duration.500ms
             x-transition.transform.origin-top.duration.500ms>
        <h2 class="font-semibold text-slate-900 mb-2">Alur Singkat Pelaksanaan Prakerin</h2>
        <ol class="list-decimal list-inside space-y-1 text-slate-600">
            <li>Penentuan tempat Prakerin dan pembagian siswa ke mitra industri.</li>
            <li>Pembekalan siswa sebelum berangkat ke tempat Prakerin.</li>
            <li>Pelaksanaan Prakerin di industri dengan pemantauan pembimbing sekolah.</li>
            <li>Pencatatan jurnal harian dan absensi melalui sistem ini.</li>
            <li>Penilaian oleh pembimbing DUDI dan pembimbing sekolah.</li>
            <li>Penyusunan laporan dan pelaksanaan sidang/ujian Prakerin.</li>
        </ol>
    </section>
@endsection
