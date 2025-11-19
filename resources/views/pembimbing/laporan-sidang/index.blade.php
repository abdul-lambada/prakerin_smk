@extends('layouts.app')

@section('title', 'Laporan & Sidang PKL')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Laporan &amp; Sidang PKL</h1>
<p class="mb-3">Daftar laporan dan berkas sidang siswa bimbingan {{ $pembimbing->nama_lengkap }}.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Laporan PKL Siswa Bimbingan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Industri</th>
                        <th>Judul Laporan</th>
                        <th>Berkas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $item)
                        <tr>
                            <td>{{ optional($item->siswa)->nama_lengkap }}</td>
                            <td>{{ optional($item->industri)->nama_industri }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>
                                @if($item->file)
                                    <a href="{{ asset('storage/'.$item->file) }}" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada laporan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Sidang PKL Siswa Bimbingan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Industri</th>
                        <th>Judul Sidang</th>
                        <th>Berkas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sidangs as $item)
                        <tr>
                            <td>{{ optional($item->siswa)->nama_lengkap }}</td>
                            <td>{{ optional($item->industri)->nama_industri }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>
                                @if($item->file)
                                    <a href="{{ asset('storage/'.$item->file) }}" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada berkas sidang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
