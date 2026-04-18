@extends('dashboard.layouts.app')

@section('content')
    <h2 style="margin-top:0;">Tambah Pendaftar Baru</h2>
    <p class="muted">Form ini dipakai admin untuk menambahkan data registrasi manual.</p>

    <form action="{{ route('dashboard.registrations.store') }}" method="POST">
        @csrf
        @php($submitLabel = 'Simpan Data')
        @include('dashboard.registrations._form')
    </form>
@endsection
