<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai PKL</title>
    <style>
        * { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; }
        h1, h2, h3, h4 { margin: 0; padding: 0; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .mt-4 { margin-top: 16px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px 6px; }
        th { background: #f2f2f2; }
        .kop-table td { border: none; }
        hr { border: 0; border-top: 2px solid #000; margin-top: 4px; margin-bottom: 8px; }
        .ttd-table td { border: none; padding: 2px 6px; }
    </style>
</head>
<body>
    {{-- Kop Sekolah --}}
    <table class="kop-table" width="100%">
        <tr>
            <td width="15%" class="text-center">
                @if(!empty($appLogo))
                    <img src="{{ public_path(str_replace('storage/', 'storage/', $appLogo)) }}" alt="Logo" style="max-height: 60px;">
                @endif
            </td>
            <td width="70%" class="text-center">
                <h2>{{ strtoupper($schoolName) }}</h2>
                @if(!empty($schoolAddress))
                    <div class="mt-1">{{ $schoolAddress }}</div>
                @endif
                @if(!empty($activeAcademicYear))
                    <div class="mt-1">Tahun Ajaran {{ $activeAcademicYear }}</div>
                @endif
            </td>
            <td width="15%"></td>
        </tr>
    </table>
    <hr>

    <div class="text-center mt-2">
        <h3>LAPORAN NILAI PRAKTIK KERJA LAPANGAN (PKL)</h3>
        @if($activePklYear)
            <div class="mt-1">Tahun PKL {{ $activePklYear }}</div>
        @endif
    </div>

    <div class="mt-3">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tempat</th>
                    <th>Nama Siswa</th>
                    <th>Nilai DU/DI</th>
                    <th>Nilai Sidang</th>
                    <th>Bobot DU/DI</th>
                    <th>Bobot Sidang</th>
                    <th>Nilai Akhir</th>
                    <th>Predikat</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilais as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ optional(optional($item->tempat)->industri)->nama_industri }}</td>
                        <td>{{ optional(optional($item->tempat)->siswa)->nama_lengkap }}</td>
                        <td class="text-center">{{ $item->nilai_du_di }}</td>
                        <td class="text-center">{{ $item->nilai_sidang }}</td>
                        <td class="text-center">{{ $item->bobot_du_di }}%</td>
                        <td class="text-center">{{ $item->bobot_sidang }}%</td>
                        <td class="text-center">{{ $item->nilai_akhir }}</td>
                        <td class="text-center">{{ $item->predikat }}</td>
                        <td>{{ $item->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">Belum ada data nilai PKL.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @php
        $kepalaSekolahNama = \App\Models\Setting::get('principal_name');
        $kepalaSekolahNip  = \App\Models\Setting::get('principal_nip');
        $koorPklNama       = \App\Models\Setting::get('pkl_coordinator_name');
        $koorPklNip        = \App\Models\Setting::get('pkl_coordinator_nip');
        $schoolCity        = \App\Models\Setting::get('school_city', '');
    @endphp

    <div class="mt-4">
        <table class="ttd-table" width="100%">
            <tr>
                <td width="50%"></td>
                <td width="50%" class="text-center">
                    {{ $schoolCity ? $schoolCity.', ' : '' }}{{ date('d-m-Y') }}
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    Mengetahui,<br>
                    Kepala Sekolah
                </td>
                <td class="text-center">
                    Koordinator PKL
                </td>
            </tr>
            <tr>
                <td class="text-center" style="height: 60px;"></td>
                <td class="text-center" style="height: 60px;"></td>
            </tr>
            <tr>
                <td class="text-center">
                    <u>{{ $kepalaSekolahNama }}</u><br>
                    @if($kepalaSekolahNip)
                        NIP. {{ $kepalaSekolahNip }}
                    @endif
                </td>
                <td class="text-center">
                    <u>{{ $koorPklNama }}</u><br>
                    @if($koorPklNip)
                        NIP. {{ $koorPklNip }}
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
