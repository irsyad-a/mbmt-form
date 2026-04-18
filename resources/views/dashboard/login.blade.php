@extends('dashboard.layouts.app')

@section('content')
    <div style="max-width: 460px; margin: 0 auto;">
        <h2 style="margin: 0 0 10px;">Login Dashboard</h2>
        <p class="muted" style="margin-top: 0; margin-bottom: 16px;">Masuk menggunakan kredensial dashboard dari konfigurasi server.</p>

        <form action="{{ route('dashboard.login.store') }}" method="POST">
            @csrf
            <div class="grid" style="grid-template-columns:1fr;">
                <div class="field">
                    <label for="username">Username</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required>
                </div>
            </div>

            <div style="margin-top: 16px; display:flex; justify-content:flex-end;">
                <button type="submit" class="btn btn-primary">Masuk Dashboard</button>
            </div>
        </form>
    </div>
@endsection
