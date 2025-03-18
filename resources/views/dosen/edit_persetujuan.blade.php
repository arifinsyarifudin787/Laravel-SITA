@extends('layouts.main')

@section('container')
    <div class="main-content">
        <div class="flex flex-col items-center justify-center">
            <h2 class="mb-4 text-3xl font-bold">Tambah Saran</h2>
            <div class="w-full px-4 md:px-0 overflow-x-auto">
                <form action="{{ route('persetujuan.bimbingan') }}" method="POST" class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
                    @method('PUT')
                    @csrf
                    <input name="persetujuan" value="{{ $persetujuan->id }}" hidden>
                    <div class="mb-4">
                        <label for="saran" class="block text-gray-700 font-medium">Saran</label>
                        <textarea id="saran" name="saran" rows="4"
                            class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" required>{{ $persetujuan->saran }}</textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection