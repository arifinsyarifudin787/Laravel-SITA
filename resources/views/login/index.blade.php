@extends("layouts.secondary")

@section("container")
    <div class="login-container">
        <h2>Login</h2>
        @if(session()->has('loginError'))
            <p class="login-error">{{ session('loginError') }}</p>
        @endif
        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <input type="submit" value="Login">
        </form>
    </div>
@endsection
