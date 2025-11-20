@extends('layouts.app')

@section('title', 'Tempat Prakerin Saya')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-4 text-gray-800">Tempat Prakerin Saya</h1>
<p class="mb-3">Daftar penempatan Prakerin untuk {{ $siswa->nama_lengkap }}.</p>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Penempatan Prakerin</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Industri</th>
                        <th>Pembimbing</th>
                        <th>Tanggal Mulai</th>
                        <th>Tahun</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tempats as $item)
                        <tr>
                            <td>{{ optional($item->industri)->nama_industri ?? '-' }}</td>
                            <td>{{ optional(optional($item->pembimbing)->user)->name }}</td>
                            <td>{{ optional($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ $item->status }}</td>
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
