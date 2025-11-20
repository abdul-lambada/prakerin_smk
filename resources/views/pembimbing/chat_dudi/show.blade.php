@extends('layouts.app')

@section('title', 'Chat dengan DUDI')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Chat dengan DUDI: {{ $dudi->name }} ({{ $dudi->username }})</h1>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Pesan</h6>
            </div>
            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                @forelse($chats as $chat)
                    @php($isFromMe = $chat->from_user_id === auth()->id())
                    <div class="mb-3 {{ $isFromMe ? 'text-right' : 'text-left' }}">
                        <div class="small text-muted mb-1">
                            {{ $chat->created_at->format('d-m-Y H:i') }} &ndash;
                            {{ $isFromMe ? 'Saya (Pembimbing)' : optional($chat->fromUser)->name }}
                            @if($chat->kategori === 'monitoring_siswa' && $chat->tempat)
                                <br><span class="badge badge-info">Monitoring: {{ optional($chat->tempat->siswa)->nama_lengkap }} ({{ $chat->kd_tempat }})</span>
                            @elseif($chat->kategori === 'kritik_saran')
                                <br><span class="badge badge-secondary">Kritik &amp; Saran</span>
                            @endif
                        </div>
                        <div class="d-inline-block px-3 py-2" style="border-radius: 16px; max-width: 75%; {{ $isFromMe ? 'background:#d1e7ff;' : 'background:#e9ecef;' }}">
                            {{ $chat->pesan }}
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Belum ada pesan.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Kirim Pesan ke DUDI</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('pembimbing.chat-dudi.store', $dudi) }}">
                    @csrf
                    <div class="form-group">
                        <label>Pesan</label>
                        <textarea name="pesan" rows="4" class="form-control @error('pesan') is-invalid @enderror" required>{{ old('pesan') }}</textarea>
                        @error('pesan')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
