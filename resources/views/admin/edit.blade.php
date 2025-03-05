@extends('layouts.main')

@section('container')
    <div class="main-content">
        <div class="flex flex-col items-center justify-center">
            <h2 class="mb-4 text-3xl font-bold">Edit Tugas Akhir</h2>
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
                <form action="{{ route('ta.update', $ta->id) }}" method="POST" class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
                    @method('PUT')
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nim" class="block text-gray-700 font-medium">NIM</label>
                        <input type="text" id="nim" name="nim" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" value="{{ $ta->nim }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700 font-medium">Nama</label>
                        <input type="text" id="nama" name="nama" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" value="{{ $ta->mahasiswa->name }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="judul" class="block text-gray-700 font-medium">Judul</label>
                        <input type="text" id="judul" name="judul" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" value="{{ $ta->judul }}" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="dosen_p1" class="block text-gray-700 font-medium">Dosen Pembimbing 1</label>
                        <select id="dosen_p1" name="dosen_p1" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" required>
                            <option value="">Pilih Dosen</option>
                            @foreach($dosens as $d)
                                <option value='{"username": "{{ $d['username'] }}", "name": "{{ $d['name'] }}"}' {{ $pembimbing1 == $d['username'] ? 'selected' : ''}}>{{ $d['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="dosen_p2" class="block text-gray-700 font-medium">Dosen Pembimbing 2</label>
                        <select id="dosen_p2" name="dosen_p2" class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300" required>
                            <option value="">Pilih Dosen</option>
                            @foreach($dosens as $d)
                                <option value='{"username": "{{ $d['username'] }}", "name": "{{ $d['name'] }}"}' {{ $pembimbing2 == $d['username'] ? 'selected' : ''}}>{{ $d['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
