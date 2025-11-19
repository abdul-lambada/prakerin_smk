@extends('layouts.app')

@section('title', 'Info / Pengumuman')

@push('styles')
<link href="{{ asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<h1 class="h3 mb-4 text-gray-800">Info / Pengumuman</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Info</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Dibuat Oleh</th>
                        <th>Lampiran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($infos as $item)
                        <tr>
                            <td>{{ $item->judul }}</td>
                            <td>{{ optional($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ optional($item->user)->name }}</td>
                            <td>
                                @if($item->file)
                                    <a href="{{ asset('storage/'.$item->file) }}" target="_blank">
                                        <i class="fas fa-paperclip"></i> Download
                                    </a>
                                @else
                                    -
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
        $('#dataTable').DataTable();
    });
</script>
@endpush
