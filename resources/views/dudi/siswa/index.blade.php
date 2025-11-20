@extends('layouts.app')

@section('title', 'Siswa PKL di Industri Saya')

@section('content')
@if($industri)
    <h1 class="h3 mb-4 text-gray-800">Siswa PKL di {{ $industri->nama_industri }}</h1>
    <p class="mb-3">Daftar siswa yang sedang / pernah PKL di industri ini.</p>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal Mulai</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Wilayah</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tempats as $tempat)
                            <tr>
                                <td>{{ optional($tempat->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ optional($tempat->siswa)->nis_siswa }}</td>
                                <td>{{ optional($tempat->siswa)->nama_lengkap }}</td>
                                <td>{{ $tempat->wilayah }}</td>
                                <td>{{ $tempat->tahun }}</td>
                                <td>{{ $tempat->status }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('dudi.nilai.edit', $tempat->kd_tempat) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-clipboard-check"></i> Nilai DU/DI
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada siswa PKL yang terdaftar untuk industri ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <h1 class="h3 mb-4 text-gray-800">Siswa PKL</h1>
    <div class="alert alert-info">
        Akun DUDI ini belum terhubung dengan data Industri mana pun.<br>
        Silakan minta admin untuk menghubungkan akun DUDI ini ke data Industri melalui menu <strong>Admin &gt; Data Industri</strong> terlebih dahulu.
    </div>
@endif
@endsection
