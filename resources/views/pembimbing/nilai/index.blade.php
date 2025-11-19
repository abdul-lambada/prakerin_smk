@extends('layouts.app')

@section('title', 'Penilaian PKL')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-4 text-gray-800">Penilaian PKL</h1>
<p class="mb-3">Daftar penempatan PKL siswa bimbingan {{ $pembimbing->nama_lengkap }} untuk diisi nilai.</p>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Penempatan PKL</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Industri / Tempat</th>
                        <th>Tahun</th>
                        <th>Nilai</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tempats as $item)
                        <tr>
                            <td>{{ optional($item->siswa)->nama_lengkap }}</td>
                            <td>{{ optional($item->industri)->nama_industri }} ({{ $item->kd_tempat }})</td>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ optional($item->nilai)->nilai ?? '-' }}</td>
                            <td>{{ optional($item->nilai)->keterangan ?? '-' }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('pembimbing.nilai.edit', $item) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-pen"></i> Nilai
                                </a>
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
