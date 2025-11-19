@extends('layouts.app')

@section('title', 'Dashboard Pembimbing')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard Pembimbing</h1>
<p class="mb-4">Selamat datang, {{ auth()->user()->name ?? auth()->user()->username }} (Pembimbing).</p>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Siswa Bimbingan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_siswa_bimbingan }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tempat PKL Binaan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_tempat }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Absensi Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $absensi_hari_ini }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jurnal Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $jurnal_hari_ini }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Laporan PKL Siswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_laporan }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-md-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">5 Info Terbaru</h6>
            </div>
            <div class="card-body">
                @if($latest_infos->isEmpty())
                    <p class="mb-0 text-muted">Belum ada info.</p>
                @else
                    <ul class="list-unstyled mb-0">
                        @foreach($latest_infos as $info)
                            <li class="mb-3">
                                <div class="small text-muted">{{ \Carbon\Carbon::parse($info->tanggal)->format('d/m/Y') }}</div>
                                <div class="font-weight-bold">{{ $info->judul }}</div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
