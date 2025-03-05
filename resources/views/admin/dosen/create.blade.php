@extends('layouts.main')

@section('container')
    <div class="main-content">
        <div class="flex flex-col items-center justify-center">
            <h2 class="mb-4 text-3xl font-bold">Tambah Data Dosen Baru</h2>
            <div class="w-full px-4 md:px-0 overflow-x-auto">
                @if (session('error'))
                <div id="alertBox" class="alert-box error">
                    <span>{{ session('error') }}</span>
                    <button id="closeAlert">✖</button>
                </div>
                @endif
                @if (session('success'))
                <div id="alertBox" class="alert-box success">
                    <span>{{ session('success') }}</span>
                    <button id="closeAlert">✖</button>
                </div>
                @endif
                <form action="{{ route('dosen.store') }}" method="POST" class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 font-medium">NIP (Username)</label>
                        <input type="text" id="username" name="username" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" value="{{ old('username') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium">Nama</label>
                        <input type="text" id="name" name="name" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="asal_pt" class="block text-gray-700 font-medium">Asal PT</label>
                        <input type="text" id="asal_pt" name="asal_pt" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" value="{{ old('asal_pt') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 font-medium">Kata sandi</label>
                        <input type="password" id="password" name="password" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" value="{{ old('password') }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="konfirmasi_sandi" class="block text-gray-700 font-medium">Konfirmasi kata sandi</label>
                        <input type="password" id="konfirmasi_sandi" name="konfirmasi_sandi" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" value="{{ old('konfirmasi_sandi') }}" required>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
