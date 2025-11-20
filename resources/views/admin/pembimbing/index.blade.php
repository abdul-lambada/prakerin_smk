@extends('layouts.app')

@section('title', 'Data Pembimbing')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Manajemen</li>
    <li class="breadcrumb-item active" aria-current="page">Data Pembimbing</li>
@endsection

@section('content')
<h1 class="h3 mb-4 text-gray-800">Data Pembimbing</h1>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card mb-3">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8 mb-3 mb-md-0">
                <form action="{{ route('admin.pembimbing.import') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-column flex-md-row align-items-md-center">
                    @csrf
                    <div class="custom-file custom-file-sm w-100 w-md-auto" style="max-width: 260px;">
                        <input type="file" name="file" class="custom-file-input" id="fileImportPembimbing" required>
                        <label class="custom-file-label" for="fileImportPembimbing">Pilih Excel/CSV</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm mt-2 mt-md-0 ml-md-2">
                        <i class="fas fa-file-import"></i> Import
                    </button>
                </form>
                <small class="text-muted d-block mt-1">Gunakan template import yang bisa di-download di samping.</small>
            </div>
            <div class="col-md-4 text-md-right">
                <a href="{{ route('admin.pembimbing.template') }}" class="btn btn-outline-secondary btn-sm mr-2 mb-1">
                    <i class="fas fa-download"></i> Download Template
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pembimbing</h6>
        <a href="{{ route('admin.pembimbing.create') }}" class="btn btn-primary btn-sm mb-1">
            <i class="fas fa-plus"></i> Tambah Pembimbing
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>User</th>
                        <th>Wilayah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembimbings as $item)
                        <tr>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ optional($item->user)->username }} - {{ optional($item->user)->name }}</td>
                            <td>{{ $item->wilayah }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.pembimbing.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $item->kd_pembimbing }}" data-nama="{{ $item->nama_lengkap }}">
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
                Apakah Anda yakin ingin menghapus data pembimbing <strong id="namaPembimbing"></strong>?
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
            var action = '{{ route('admin.pembimbing.destroy', ':id') }}'.replace(':id', id);

            $('#namaPembimbing').text(nama);
            $('#formDelete').attr('action', action);
        });
    });
</script>
@endpush
