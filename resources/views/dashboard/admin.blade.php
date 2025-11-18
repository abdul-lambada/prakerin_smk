@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>
<p>Selamat datang, {{ auth()->user()->name ?? auth()->user()->username }} (Admin).</p>
@endsection
