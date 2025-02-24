@extends('layouts.main')

@section('container')
    <div class="main-content">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <h2 class="mb-4 text-3xl font-bold">Tambah Bimbingan</h2>

            <form action="{{ route('bimbingan.store') }}" method="POST" class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
                @csrf
                
                <div class="mb-4">
                    <label for="tanggal" class="block text-gray-700 font-medium">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal_bimbingan" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                </div>
                
                <div class="mb-4">
                    <label for="bab" class="block text-gray-700 font-medium">Bab</label>
                    <select id="bab" name="bab" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                        <option value="">Pilih Bab</option>
                        <option value="I">Bab I</option>
                        <option value="II">Bab II</option>
                        <option value="III">Bab III</option>
                        <option value="IV">Bab IV</option>
                        <option value="V">Bab V</option>
                    </select>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
