@extends('layouts.app')

@section('title', 'Laporan PKL Saya')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-4 text-gray-800">Laporan PKL Saya</h1>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan PKL</h6>
        <a href="{{ route('siswa.laporan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-upload"></i> Upload Laporan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tempat / Industri</th>
                        <th>Berkas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporans as $item)
                        <tr>
                            <td>{{ $item->judul }}</td>
                            <td>
                                {{ optional($item->tempat)->kd_tempat }} -
                                {{ optional(optional($item->tempat)->industri)->nama_industri }}
                            </td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('sb-admin-2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
