@extends('layouts.app')

@section('title', 'Bimbingan Prakerin Saya')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-4 text-gray-800">Bimbingan Prakerin Saya</h1>
<p class="mb-3">Pilih tempat Prakerin untuk membuka ruang bimbingan dengan pembimbing.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Tempat Prakerin</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode Tempat</th>
                        <th>Industri</th>
                        <th>Pembimbing</th>
                        <th>Tanggal Mulai</th>
                        <th>Tahun</th>
                        <th>Revisi Laporan</th>
                        <th>Belum Dibaca</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tempats as $item)
                        <tr>
                            <td>{{ $item->kd_tempat }}</td>
                            <td>{{ optional($item->industri)->nama_industri }}</td>
                            <td>{{ optional(optional($item->pembimbing)->user)->name }}</td>
                            <td>{{ optional($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td>
                                @php($revisi = $item->revisi_laporan_count ?? 0)
                                @if($revisi > 0)
                                    <span class="badge badge-info">{{ $revisi }}x Revisi</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @php($unread = $item->unread_from_pembimbing_count ?? 0)
                                @if($unread > 0)
                                    <span class="badge badge-danger">{{ $unread }} pesan baru</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('siswa.bimbingan.show', $item) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-comments"></i> Buka Bimbingan
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
