@extends('layouts.app')

@section('title', 'Monitoring Harian & Bimbingan Prakerin')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush>

<!-- Modal Detail Absensi -->
<div class="modal fade" id="detailAbsensiModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Absensi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Tanggal</dt>
                    <dd class="col-sm-8" id="detailAbsensiTanggal"></dd>

                    <dt class="col-sm-4">Siswa</dt>
                    <dd class="col-sm-8" id="detailAbsensiSiswa"></dd>

                    <dt class="col-sm-4">Tempat</dt>
                    <dd class="col-sm-8" id="detailAbsensiTempat"></dd>

                    <dt class="col-sm-4">Jam Masuk</dt>
                    <dd class="col-sm-8" id="detailAbsensiJamMasuk"></dd>

                    <dt class="col-sm-4">Jam Keluar</dt>
                    <dd class="col-sm-8" id="detailAbsensiJamKeluar"></dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8" id="detailAbsensiStatus"></dd>

                    <dt class="col-sm-4">Keterangan</dt>
                    <dd class="col-sm-8" id="detailAbsensiKeterangan"></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Jurnal -->
<div class="modal fade" id="detailJurnalModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Jurnal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Tanggal</dt>
                    <dd class="col-sm-8" id="detailJurnalTanggal"></dd>

                    <dt class="col-sm-4">Siswa</dt>
                    <dd class="col-sm-8" id="detailJurnalSiswa"></dd>

                    <dt class="col-sm-4">Tempat</dt>
                    <dd class="col-sm-8" id="detailJurnalTempat"></dd>

                    <dt class="col-sm-4">Jam Mulai</dt>
                    <dd class="col-sm-8" id="detailJurnalJamMulai"></dd>

                    <dt class="col-sm-4">Jam Selesai</dt>
                    <dd class="col-sm-8" id="detailJurnalJamSelesai"></dd>

                    <dt class="col-sm-4">Kegiatan</dt>
                    <dd class="col-sm-8" id="detailJurnalKegiatan"></dd>

                    <dt class="col-sm-4">Deskripsi</dt>
                    <dd class="col-sm-8" id="detailJurnalDeskripsi"></dd>
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@section('content')
<h1 class="h3 mb-4 text-gray-800">Monitoring Harian &amp; Bimbingan Prakerin</h1>
<p class="mb-3">Riwayat absensi dan jurnal harian siswa bimbingan Prakerin oleh {{ $pembimbing->nama_lengkap }}.</p>

{{-- ABSENSI --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Absensi Siswa Bimbingan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="absensiTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Tempat</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absensis as $item)
                        <tr>
                            <td>{{ optional($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ optional($item->siswa)->nama_lengkap }}</td>
                            <td>{{ optional(optional($item->tempat)->industri)->nama_industri ?? '-' }}</td>
                            <td>{{ $item->jam_masuk }}</td>
                            <td>{{ $item->jam_keluar }}</td>
                            <td>{{ $item->status }}</td>
                            <td class="text-nowrap">
                                <button type="button" class="btn btn-sm btn-info btn-detail-absensi"
                                    data-toggle="modal" data-target="#detailAbsensiModal"
                                    data-tanggal="{{ optional($item->tanggal)->format('d-m-Y') }}"
                                    data-siswa="{{ optional($item->siswa)->nama_lengkap }}"
                                    data-tempat="{{ optional(optional($item->tempat)->industri)->nama_industri ?? '-' }}"
                                    data-jam-masuk="{{ $item->jam_masuk }}"
                                    data-jam-keluar="{{ $item->jam_keluar }}"
                                    data-status="{{ $item->status }}"
                                    data-keterangan="{{ $item->keterangan }}">
                                    <i class="fas fa-search"></i> Detail
                                </button>
                                @if($item->foto)
                                    <a href="{{ asset('storage/'.$item->foto) }}" target="_blank" class="btn btn-sm btn-secondary mt-1">
                                        <i class="fas fa-camera"></i>
                                    </a>
                                @endif
                                @if($item->tempat)
                                    @php($unread = $unreadBimbingan[$item->kd_tempat] ?? 0)
                                    <a href="{{ route('pembimbing.bimbingan.show', $item->tempat) }}" class="btn btn-sm btn-primary mt-1 position-relative">
                                        <i class="fas fa-comments"></i>
                                        @if($unread > 0)
                                            <span class="badge badge-danger" style="position:absolute; top:-5px; right:-5px; font-size:0.7rem;">
                                                {{ $unread }}
                                            </span>
                                        @endif
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- JURNAL --}}
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Jurnal Siswa Bimbingan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="jurnalTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Tempat</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Kegiatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurnals as $item)
                        <tr>
                            <td>{{ optional($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ optional($item->siswa)->nama_lengkap }}</td>
                            <td>{{ optional(optional($item->tempat)->industri)->nama_industri ?? '-' }}</td>
                            <td>{{ $item->jam_mulai }}</td>
                            <td>{{ $item->jam_selesai }}</td>
                            <td>{{ $item->kegiatan }}</td>
                            <td class="text-nowrap">
                                <button type="button" class="btn btn-sm btn-info btn-detail-jurnal"
                                    data-toggle="modal" data-target="#detailJurnalModal"
                                    data-tanggal="{{ optional($item->tanggal)->format('d-m-Y') }}"
                                    data-siswa="{{ optional($item->siswa)->nama_lengkap }}"
                                    data-tempat="{{ optional(optional($item->tempat)->industri)->nama_industri ?? '-' }}"
                                    data-jam-mulai="{{ $item->jam_mulai }}"
                                    data-jam-selesai="{{ $item->jam_selesai }}"
                                    data-kegiatan="{{ $item->kegiatan }}"
                                    data-deskripsi="{{ $item->deskripsi }}">
                                    <i class="fas fa-search"></i> Detail
                                </button>
                                @if($item->foto)
                                    <a href="{{ asset('storage/'.$item->foto) }}" target="_blank" class="btn btn-sm btn-secondary mt-1">
                                        <i class="fas fa-file-image"></i>
                                    </a>
                                @endif
                                @if($item->tempat)
                                    <a href="{{ route('pembimbing.bimbingan.show', $item->tempat) }}" class="btn btn-sm btn-primary mt-1">
                                        <i class="fas fa-comments"></i>
                                    </a>
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
        $('#absensiTable').DataTable();
        $('#jurnalTable').DataTable();

        $('#detailAbsensiModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $('#detailAbsensiTanggal').text(button.data('tanggal'));
            $('#detailAbsensiSiswa').text(button.data('siswa'));
            $('#detailAbsensiTempat').text(button.data('tempat'));
            $('#detailAbsensiJamMasuk').text(button.data('jam-masuk'));
            $('#detailAbsensiJamKeluar').text(button.data('jam-keluar'));
            $('#detailAbsensiStatus').text(button.data('status'));
            $('#detailAbsensiKeterangan').text(button.data('keterangan') || '-');
        });

        $('#detailJurnalModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $('#detailJurnalTanggal').text(button.data('tanggal'));
            $('#detailJurnalSiswa').text(button.data('siswa'));
            $('#detailJurnalTempat').text(button.data('tempat'));
            $('#detailJurnalJamMulai').text(button.data('jam-mulai'));
            $('#detailJurnalJamSelesai').text(button.data('jam-selesai'));
            $('#detailJurnalKegiatan').text(button.data('kegiatan'));
            $('#detailJurnalDeskripsi').text(button.data('deskripsi') || '-');
        });
    });
</script>
@endpush