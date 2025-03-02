@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="flex flex-col items-center justify-center h-screen">
        <h2 class="mb-4 text-3xl font-bold">Dashboard</h2>

        <!-- Tabel Mahasiswa -->
        <table class="table-auto border-collapse border border-gray-400 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-400 px-4 py-2">No</th>
                    <th class="border border-gray-400 px-4 py-2">Nama Mahasiswa</th>
                    <th class="border border-gray-400 px-4 py-2">Bimbingan Terakhir</th>
                    <th class="border border-gray-400 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswas as $mahasiswa)
                    @php
                        $bimbinganTerakhir = $mahasiswa->terakhirBimbingan();
                    @endphp
                    <tr>
                        <td class="border border-gray-400 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border border-gray-400 px-4 py-2">{{ $mahasiswa->name }}</td>
                        <td class="border border-gray-400 px-4 py-2">
                            {{ $bimbinganTerakhir ? $bimbinganTerakhir->tanggal() : '-' }}
                        </td>
                        <td class="border border-gray-400 px-4 py-2 text-center">
                            <a href="/mahasiswa/{{ $mahasiswa->id }}" class="btn-detail">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data Mahasiswa</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
