@extends('layouts.app')

@section('title', 'Data Absensi PKL')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Laporan Jurnal &amp; Absensi</li>
    <li class="breadcrumb-item active" aria-current="page">Absensi PKL</li>
@endsection

@section('content')
<h1 class="h3 mb-4 text-gray-800">Data Absensi PKL</h1>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="GET" action="{{ route('admin.absensi.index') }}" class="mb-3">
    <div class="form-row">
        <div class="form-group col-md-3">
            <label>Jurusan</label>
            <select name="jurusan" class="form-control">
                <option value="">Semua Jurusan</option>
                @foreach($jurusans as $jurusan)
                    <option value="{{ $jurusan->kd_jurusan }}" {{ ($filters['jurusan'] ?? '') == $jurusan->kd_jurusan ? 'selected' : '' }}>
                        {{ $jurusan->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label>Kelas</label>
            <select name="kelas" class="form-control">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->kd_kelas }}" {{ ($filters['kelas'] ?? '') == $kelas->kd_kelas ? 'selected' : '' }}>
                        {{ $kelas->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-3">
            <label>Tahun PKL</label>
            <select name="tahun" class="form-control">
                <option value="">Semua Tahun</option>
                @foreach($tahunList as $tahun)
                    <option value="{{ $tahun }}" {{ ($filters['tahun'] ?? '') == $tahun ? 'selected' : '' }}>
                        {{ $tahun }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary btn-block">Filter</button>
        </div>
    </div>
</form>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Absensi</h6>
        <div>
            <a href="{{ route('admin.absensi.export-csv') }}" class="btn btn-outline-success btn-sm border mr-2">
                <i class="fas fa-file-excel"></i> Export CSV
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary btn-sm border mr-2">
                <i class="fas fa-file-alt"></i> Kembali ke Laporan
            </a>
            <a href="{{ route('admin.absensi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Absensi
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Tempat</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensis as $item)
                        <tr>
                            <td>{{ optional($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ optional($item->siswa)->nama_lengkap }}</td>
                            <td>{{ optional(optional($item->tempat)->industri)->nama_industri }}</td>
                            <td>{{ $item->jam_masuk }}</td>
                            <td>{{ $item->jam_keluar }}</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                @if($item->foto)
                                    <img src="{{ asset('storage/'.$item->foto) }}" alt="Foto absensi" style="width: 50px; height: 50px; object-fit: cover;" class="img-thumbnail">
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.absensi.edit', $item) }}" class="btn btn-sm btn.warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $item->kd_absensi }}" data-nama="{{ optional($item->siswa)->nama_lengkap }}">
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
                Apakah Anda yakin ingin menghapus data absensi untuk <strong id="namaSiswaAbsensi"></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="formDeleteAbsensi" method="POST" action="#">
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
            var action = '{{ route('admin.absensi.destroy', ':id') }}'.replace(':id', id);

            $('#namaSiswaAbsensi').text(nama);
            $('#formDeleteAbsensi').attr('action', action);
        });
    });
</script>
@endpush
