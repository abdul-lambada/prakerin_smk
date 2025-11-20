@extends('layouts.app')

@section('title', 'Data Siswa')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Manajemen</li>
    <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
@endsection

@section('content')
<h1 class="h3 mb-4 text-gray-800">Data Siswa</h1>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa</h6>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Siswa
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Pembimbing</th>
                        <th>Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $item)
                        <tr>
                            <td>{{ $item->nis_siswa }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ optional($item->kelas)->nama }} - {{ optional(optional($item->kelas)->jurusan)->nama }}</td>
                            <td>{{ optional(optional($item->pembimbing)->user)->name }}</td>
                            <td>{{ $item->telp }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.siswa.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $item->nis_siswa }}" data-nama="{{ $item->nama_lengkap }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data siswa <strong id="namaSiswa"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="formDelete" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
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

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var action = '{{ route('admin.siswa.destroy', ':id') }}'.replace(':id', id);

            $('#namaSiswa').text(nama);
            $('#formDelete').attr('action', action);
        });
    });
</script>
@endpush
