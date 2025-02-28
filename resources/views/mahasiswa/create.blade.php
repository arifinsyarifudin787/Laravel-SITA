@extends('layouts.main')

@section('container')
    <div class="main-content">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <h2 class="mb-4 text-3xl font-bold">Tambah Bimbingan</h2>

            <form action="{{ route('bimbingan.store') }}" method="POST" class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
                @csrf
                
                <div class="mb-4">
                    <label for="tanggal" class="block text-gray-700 font-medium">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal_bimbingan" value="{{ old('tanggal_bimbingan') }}" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                </div>
                
                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700 font-medium">Deskripsi</label>
                    <input type="text" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                </div>
                
                <div class="mb-4">
                    <label for="dosen" class="block text-gray-700 font-medium">Dosen Pembimbing</label>
                    <select id="dosen" name="dosen" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                        <option value="">Pilih Dosen Pembimbing</option>
                    </select>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
