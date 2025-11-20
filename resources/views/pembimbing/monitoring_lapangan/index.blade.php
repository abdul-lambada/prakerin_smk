@extends('layouts.app')

@section('title', 'Monitoring Lapangan Prakerin')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-4 text-gray-800">Monitoring Lapangan Prakerin</h1>
<p class="mb-3">Daftar catatan monitoring lapangan Prakerin untuk siswa bimbingan {{ $pembimbing->nama_lengkap }}.</p>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Monitoring Lapangan Prakerin</h6>
        <a href="{{ route('pembimbing.monitoring-lapangan.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Monitoring
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="monitoringTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Tempat / Industri</th>
                        <th>Catatan</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monitorings as $item)
                        <tr>
                            <td>{{ optional($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ optional(optional($item->tempat)->industri)->nama_industri ?? '-' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->catatan, 120) }}</td>
                            <td class="text-center">
                                @if($item->foto)
                                    <a href="{{ asset('storage/'.$item->foto) }}" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-file-image"></i>
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('pembimbing.monitoring-lapangan.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger btn-delete-monitoring"
                                        data-toggle="modal"
                                        data-target="#deleteMonitoringModal"
                                        data-url="{{ route('pembimbing.monitoring-lapangan.destroy', $item) }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada catatan monitoring lapangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteMonitoringModal" tabindex="-1" role="dialog" aria-labelledby="deleteMonitoringLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMonitoringLabel">Hapus Monitoring Lapangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus catatan monitoring ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form method="POST" id="deleteMonitoringForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
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
        $('#monitoringTable').DataTable();

        $('#deleteMonitoringModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var url = button.data('url');
            $('#deleteMonitoringForm').attr('action', url);
        });
    });
</script>
@endpush