<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
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
</body>
</html>
