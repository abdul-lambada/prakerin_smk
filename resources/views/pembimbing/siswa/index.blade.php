@extends('layouts.app')

@section('title', 'Siswa Bimbingan')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-4 text-gray-800">Siswa Bimbingan</h1>
<p class="mb-3">Daftar siswa yang dibimbing oleh {{ $pembimbing->nama_lengkap }}.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa Bimbingan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $item)
                        <tr>
                            <td>{{ $item->nis_siswa }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ optional($item->kelas)->nama }} - {{ optional(optional($item->kelas)->jurusan)->nama }}</td>
                            <td>{{ $item->telp }}</td>
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
