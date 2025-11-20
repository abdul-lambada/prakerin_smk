@extends('layouts.app')

@section('title', 'Ruang Bimbingan Prakerin')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Ruang Bimbingan Prakerin</h1>

<div class="card mb-4">
    <div class="card-body">
        <dl class="row mb-0">
            <dt class="col-sm-3">Siswa</dt>
            <dd class="col-sm-9">{{ $siswa->nama_lengkap }}</dd>

            <dt class="col-sm-3">Tempat Prakerin</dt>
            <dd class="col-sm-9">{{ $tempat->kd_tempat }} - {{ optional($tempat->industri)->nama_industri }}</dd>

            <dt class="col-sm-3">Pembimbing</dt>
            <dd class="col-sm-9">{{ optional(optional($tempat->pembimbing)->user)->name ?? '-' }}</dd>
        </dl>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Bimbingan</h6>
    </div>
    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
        <form method="GET" class="form-inline mb-3">
            <label class="mr-2">Filter status</label>
            <select name="filter_judul" class="form-control form-control-sm mr-2">
                <option value="">Semua</option>
                <option value="Revisi Laporan" {{ ($selectedFilter ?? '') == 'Revisi Laporan' ? 'selected' : '' }}>Revisi Laporan</option>
                <option value="Revisi Bab 1" {{ ($selectedFilter ?? '') == 'Revisi Bab 1' ? 'selected' : '' }}>Revisi Bab 1</option>
                <option value="Revisi Bab 2" {{ ($selectedFilter ?? '') == 'Revisi Bab 2' ? 'selected' : '' }}>Revisi Bab 2</option>
                <option value="Cek Jurnal" {{ ($selectedFilter ?? '') == 'Cek Jurnal' ? 'selected' : '' }}>Cek Jurnal</option>
                <option value="Umum" {{ ($selectedFilter ?? '') == 'Umum' ? 'selected' : '' }}>Umum</option>
            </select>
            <button class="btn btn-sm btn-primary" type="submit">Terapkan</button>
        </form>
        @forelse($bimbingans as $item)
            @php($isFromPembimbing = !empty($item->nip))
            <div class="d-flex mb-3 {{ $isFromPembimbing ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="px-3 py-2" style="max-width: 70%; border-radius: 18px; {{ $isFromPembimbing ? 'background:#d1e7ff; text-align:right;' : 'background:#e9ecef;' }}">
                    <div class="small text-muted mb-1">
                        {{ optional($item->tanggal)->format('d-m-Y') }} &ndash;
                        {{ $isFromPembimbing ? 'Pembimbing' : 'Saya' }}
                    </div>
                    @if($item->judul)
                        <div class="mb-1">
                            <span class="badge
                                @if($item->judul === 'Revisi Laporan') badge-danger
                                @elseif(\Illuminate\Support\Str::startsWith($item->judul, 'Revisi Bab')) badge-warning
                                @elseif($item->judul === 'Cek Jurnal') badge-info
                                @else badge-secondary
                                @endif
                            ">{{ $item->judul }}</span>
                        </div>
                    @endif
                    <div>{{ $item->catatan }}</div>
                    @if($item->file)
                        <div class="mt-1">
                            <a href="{{ asset('storage/'.$item->file) }}" target="_blank">
                                <i class="fas fa-paperclip"></i> Lampiran
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted mb-0">Belum ada bimbingan.</p>
        @endforelse
    </div>
</div>

<div class="card mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Kirim Pesan Bimbingan</h6>
    </div>
    <div class="card-body">
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('siswa.bimbingan.store', $tempat) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Status / Topik</label>
                <select name="judul" class="form-control @error('judul') is-invalid @enderror">
                    <option value="Umum" {{ old('judul') == 'Umum' ? 'selected' : '' }}>Umum</option>
                    <option value="Revisi Laporan" {{ old('judul') == 'Revisi Laporan' ? 'selected' : '' }}>Revisi Laporan</option>
                    <option value="Revisi Bab 1" {{ old('judul') == 'Revisi Bab 1' ? 'selected' : '' }}>Revisi Bab 1</option>
                    <option value="Revisi Bab 2" {{ old('judul') == 'Revisi Bab 2' ? 'selected' : '' }}>Revisi Bab 2</option>
                    <option value="Cek Jurnal" {{ old('judul') == 'Cek Jurnal' ? 'selected' : '' }}>Cek Jurnal</option>
                </select>
                @error('judul')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Pesan / Catatan</label>
                <textarea name="catatan" rows="4" class="form-control @error('catatan') is-invalid @enderror" required>{{ old('catatan') }}</textarea>
                @error('catatan')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="form-group">
                <label>Lampiran (opsional)</label>
                <input type="file" name="file" class="form-control-file @error('file') is-invalid @enderror">
                <small class="form-text text-muted">Bisa mengirim draft laporan atau berkas pendukung lainnya (max 4 MB).</small>
                @error('file')
                    <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <a href="{{ route('siswa.bimbingan.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
        </form>
    </div>
</div>
@endsection
