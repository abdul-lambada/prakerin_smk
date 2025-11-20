@extends('layouts.app')

@section('title', 'Nilai PKL')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}">Dashboard</a></li>
    <li class="breadcrumb-item">Nilai &amp; Sidang</li>
    <li class="breadcrumb-item active" aria-current="page">Nilai PKL</li>
@endsection

@section('content')
<h1 class="h3 mb-4 text-gray-800">Nilai PKL</h1>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<form method="GET" action="{{ route('admin.nilai.index') }}" class="mb-3">
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
        <div class="form-group col-md-2">
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
        <div class="form-group col-md-3">
            <label>Industri</label>
            <select name="industri" class="form-control">
                <option value="">Semua Industri</option>
                @foreach($industris as $industri)
                    <option value="{{ $industri->kd_industri }}" {{ ($filters['industri'] ?? '') == $industri->kd_industri ? 'selected' : '' }}>
                        {{ $industri->nama_industri }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary btn-block">Filter</button>
        </div>
    </div>
</form>

<div class="row mb-3">
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Data Nilai</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rekap['total'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Rata-rata Nilai Akhir</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rekap['rata_nilai_akhir'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Rekap per Jurusan</div>
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Jurusan</th>
                            <th>Jumlah</th>
                            <th>Rata Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapPerJurusan as $namaJurusan => $data)
                            <tr>
                                <td>{{ $namaJurusan }}</td>
                                <td>{{ $data['jumlah'] }}</td>
                                <td>{{ $data['rata_nilai_akhir'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Rekap per Industri</div>
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>Industri</th>
                            <th>Total Siswa</th>
                            <th>Lulus</th>
                            <th>Tidak Lulus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapPerIndustri as $namaIndustri => $data)
                            <tr>
                                <td>{{ $namaIndustri }}</td>
                                <td>{{ $data['total'] }}</td>
                                <td>{{ $data['lulus'] }}</td>
                                <td>{{ $data['tidak_lulus'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Nilai PKL</h6>
        <div>
            <a href="{{ route('admin.nilai.cetak-pdf') }}" class="btn btn-outline-danger btn-sm border mr-2" target="_blank">
                <i class="fas fa-file-pdf"></i> Cetak PDF
            </a>
            <a href="{{ route('admin.nilai.export-csv', request()->query()) }}" class="btn btn-outline-success btn-sm border mr-2">
                <i class="fas fa-file-excel"></i> Export CSV
            </a>
            <a href="{{ route('admin.sidang.index') }}" class="btn btn-secondary btn-sm border mr-2">
                <i class="fas fa-gavel"></i> Data Sidang
            </a>
            <a href="{{ route('admin.nilai.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Nilai
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tempat</th>
                        <th>Siswa</th>
                        <th>Nilai DU/DI</th>
                        <th>Nilai Sidang</th>
                        <th>Bobot (DU/DI - Sidang)</th>
                        <th>Nilai Akhir</th>
                        <th>Predikat</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nilais as $item)
                        <tr>
                            <td>{{ optional(optional($item->tempat)->industri)->nama_industri }}</td>
                            <td>{{ optional(optional($item->tempat)->siswa)->nama_lengkap }}</td>
                            <td>{{ $item->nilai_du_di }}</td>
                            <td>{{ $item->nilai_sidang }}</td>
                            <td>{{ $item->bobot_du_di }}% - {{ $item->bobot_sidang }}%</td>
                            <td>{{ $item->nilai_akhir }}</td>
                            <td>{{ $item->predikat }}</td>
                            <td>{{ $item->keterangan }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.nilai.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $item->kd_nilai }}" data-nama="{{ optional(optional($item->tempat)->siswa)->nama_lengkap }}">
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
                Apakah Anda yakin ingin menghapus nilai PKL untuk <strong id="namaSiswa"></strong>?
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
            var action = '{{ route('admin.nilai.destroy', ':id') }}'.replace(':id', id);

            $('#namaSiswa').text(nama);
            $('#formDelete').attr('action', action);
        });
    });
</script>
@endpush
