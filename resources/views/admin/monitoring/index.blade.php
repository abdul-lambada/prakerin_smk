@extends('layouts.app')

@section('title', 'Monitoring Lapangan - Admin')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-4 text-gray-800">Monitoring Lapangan</h1>
<p class="mb-3">Daftar seluruh catatan monitoring lapangan dari semua pembimbing dan siswa.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Monitoring Lapangan</h6>
        <form method="GET" class="form-inline mb-0">
            <label class="mr-2 mb-0">Tahun</label>
            <select name="tahun" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                <option value="">Semua</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="adminMonitoringTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Industri</th>
                        <th>Siswa</th>
                        <th>Pembimbing</th>
                        <th>Catatan</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monitorings as $item)
                        <tr>
                            <td>{{ optional($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ optional(optional($item->tempat)->industri)->nama_industri ?? '-' }}</td>
                            <td>{{ optional(optional($item->tempat)->siswa)->nama_lengkap ?? '-' }}</td>
                            <td>{{ optional(optional($item->tempat)->pembimbing)->nama_lengkap ?? '-' }}</td>
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada catatan monitoring lapangan.</td>
                        </tr>
                    @endforelse
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
        $('#adminMonitoringTable').DataTable();
    });
</script>
@endpush
