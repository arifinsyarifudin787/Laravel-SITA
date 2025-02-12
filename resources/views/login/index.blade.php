@extends("layouts.main")

@section("container")
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-2xl font-bold text-center">Login</h2>
        @if(session()->has('loginError'))
            <p class="p-2 mb-4 text-sm text-red-600 bg-red-100 rounded">{{ session('loginError') }}</p>
        @endif
        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-sm font-semibold text-gray-700">Username</label>
                <input type="text" id="username" name="username" required class="w-full p-2 mt-1 border rounded focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" id="password" name="password" required class="w-full p-2 mt-1 border rounded focus:ring focus:ring-blue-300">
            </div>
            <button type="submit" class="w-full p-2 text-white bg-blue-600 rounded hover:bg-blue-700">Login</button>
        </form>
    </div>
@endsection