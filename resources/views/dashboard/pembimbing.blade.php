@extends('layouts.app')

@section('title', 'Dashboard Pembimbing')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard Pembimbing</h1>
<p>Selamat datang, {{ auth()->user()->name ?? auth()->user()->username }} (Pembimbing).</p>
@endsection
