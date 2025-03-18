@extends('layouts.main')

@section('container')
    <div class="main-content">
        <div class="flex flex-col items-center justify-center">
            <h2 class="mb-4 text-3xl font-bold">Tambah Bimbingan</h2>
            <div class="w-full px-4 md:px-0 overflow-x-auto">
                @if (session('error'))
                <div id="alertBox" class="alert-box error">
                    <span>{{ session('error') }}</span>
                    <button id="closeAlert">✖</button>
                </div>
                @endif
                @if (session('success'))
                <div id="alertBox" class="alert-box w-full max-w-md success">
                    <span>{{ session('success') }}</span>
                    <button id="closeAlert">✖</button>
                </div>
                @endif
                <form action="{{ route('bimbingan.store') }}" method="POST" class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="tanggal" class="block text-gray-700 font-medium">Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal_bimbingan"
                            value="{{ old('tanggal_bimbingan') }}" 
                            class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" required>
                    </div>
                    <div class="mb-4">
                        <label for="materi" class="block text-gray-700 font-medium">Materi</label>
                        <textarea id="materi" name="materi" rows="4"
                            class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" required>{{ old('materi') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="dosen" class="block text-gray-700 font-medium">Dosen Pembimbing</label>
                        <select id="dosen" name="dosen" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" required>
                            <option value="">Pilih Dosen Pembimbing</option>
                            @foreach ($dosens as $d)
                            <option value="{{ $d->id }}" {{ old('dosen') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
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