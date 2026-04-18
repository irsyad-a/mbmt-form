@extends('dashboard.layouts.app')

@section('content')
    <h2 style="margin-top:0;">Edit Data Pendaftar</h2>
    <p class="muted">Perbarui informasi pendaftar sesuai kebutuhan.</p>

    <form action="{{ route('dashboard.registrations.update', $registration) }}" method="POST">
        @csrf
        @method('PUT')
        @php($submitLabel = 'Update Data')
        @include('dashboard.registrations._form')
    </form>
@endsection
