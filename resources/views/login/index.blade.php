@extends("layouts.secondary")

@section("container")
    <div class="login-container">
        <div class="logo-container">
            <img src="{{ asset('assets/img/logo.png') }}" alt="sakti-logo" width="150px">
        </div>
        
        @if(session('error'))
        <div id="alertBox" class="alert-box error">
            <span>{{ session('error') }}</span>
            <button id="closeAlert">✖</button>
        </div>
        @endif
        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="info-sita">
                * Mahasiswa login dengan akun SALAM
                <br>
                * Dosen login dengan akun SIP
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
@endsection
