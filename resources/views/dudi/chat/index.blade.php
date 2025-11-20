@extends('layouts.app')

@section('title', 'Chat Pembimbing')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Chat dengan Pembimbing</h1>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

@if(! $industri)
    <div class="alert alert-warning">
        Akun DUDI ini belum terhubung ke data Industri. Hubungi admin untuk mengaitkan industri.
    </div>
@else
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Kirim Pesan ke Pembimbing</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dudi.chat.store') }}">
                        @csrf

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" id="kategoriSelect" required>
                                <option value="kritik_saran" {{ old('kategori') == 'kritik_saran' ? 'selected' : '' }}>Kritik &amp; Saran</option>
                                <option value="monitoring_siswa" {{ old('kategori') == 'monitoring_siswa' ? 'selected' : '' }}>Monitoring Siswa</option>
                            </select>
                            @error('kategori')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group" id="pembimbingWrapper">
                            <label>Pilih Pembimbing (untuk Kritik &amp; Saran)</label>
                            <select name="pembimbing_id" class="form-control @error('pembimbing_id') is-invalid @enderror">
                                <option value="">-- Pilih Pembimbing --</option>
                                @foreach($pembimbingUsers as $p)
                                    <option value="{{ $p->id }}" {{ old('pembimbing_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }} ({{ $p->username }})
                                    </option>
                                @endforeach
                            </select>
                            @error('pembimbing_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group d-none" id="tempatWrapper">
                            <label>Pilih Siswa / Tempat (untuk Monitoring Siswa)</label>
                            <select name="kd_tempat" class="form-control @error('kd_tempat') is-invalid @enderror">
                                <option value="">-- Pilih Siswa / Tempat --</option>
                                @foreach($tempats as $t)
                                    <option value="{{ $t->kd_tempat }}" {{ old('kd_tempat') == $t->kd_tempat ? 'selected' : '' }}>
                                        {{ $t->kd_tempat }} - {{ optional($t->siswa)->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kd_tempat')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Pesan</label>
                            <textarea name="pesan" rows="4" class="form-control @error('pesan') is-invalid @enderror" required>{{ old('pesan') }}</textarea>
                            @error('pesan')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
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
                                {{ $isFromMe ? 'Saya (DUDI)' : optional($chat->fromUser)->name }}
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
    </div>
@endif
@endsection

@push('scripts')
<script>
    (function() {
        function toggleKategori() {
            var kategori = document.getElementById('kategoriSelect').value;
            var pembimbingWrapper = document.getElementById('pembimbingWrapper');
            var tempatWrapper = document.getElementById('tempatWrapper');

            if (kategori === 'monitoring_siswa') {
                pembimbingWrapper.classList.add('d-none');
                tempatWrapper.classList.remove('d-none');
            } else {
                pembimbingWrapper.classList.remove('d-none');
                tempatWrapper.classList.add('d-none');
            }
        }

        document.getElementById('kategoriSelect').addEventListener('change', toggleKategori);
        toggleKategori();
    })();
</script>
@endpush
