@extends('layouts.app')

@section('title', 'Chat DUDI')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Chat dengan DUDI</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar DUDI / Industri</h6>
    </div>
    <div class="card-body">
        @if($dudiUsers->isEmpty())
            <p class="text-muted mb-0">Belum ada DUDI yang terhubung dengan siswa bimbingan Anda.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama DUDI</th>
                            <th>Username</th>
                            <th>Pesan Baru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dudiUsers as $dudi)
                            @php($unread = $unreadCounts[$dudi->id] ?? 0)
                            <tr>
                                <td>{{ $dudi->name }}</td>
                                <td>{{ $dudi->username }}</td>
                                <td>
                                    @if($unread > 0)
                                        <span class="badge badge-danger">{{ $unread }} pesan baru</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pembimbing.chat-dudi.show', $dudi) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-comments"></i> Buka Chat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
