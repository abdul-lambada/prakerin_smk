@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard Siswa</h1>
<p>Selamat datang, {{ auth()->user()->name ?? auth()->user()->username }} (Siswa).</p>
@endsection
