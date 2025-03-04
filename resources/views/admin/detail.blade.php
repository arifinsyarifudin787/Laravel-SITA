@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="flex flex-col items-center justify-center h-screen">
        <h2 class="mb-4 text-3xl font-bold">{{ $mahasiswa->name }}</h2>
        Judul TA: {{ $mahasiswa->tugasAkhir->judul }} 
        @foreach ($mahasiswa->pembimbings as $index => $p)
        <br>
        Pembimbing {{ $index + 1 }}: {{ $p->name }}
        @endforeach
        
        <!-- Tabel Detail Bimbingan -->
        <table class="table-auto border-collapse border border-gray-400 mt-4">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Bimbingan</th>
                    <th>Deskripsi</th>
                    <th>Dosen 1</th>
                    <th>Dosen 2</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswa->bimbingans as $index => $bimbingan)
                <tr>
                    <td>{{ $index + 1 }}</td> 
                    <td>{{ $bimbingan->tanggal() }}</td>
                    <td>{{ $bimbingan->deskripsi }}</td>
                    <td>{{ $bimbingan->persetujuanPembimbing1 ? $bimbingan->persetujuanPembimbing1->status : '-' }}</td>
                    <td>{{ $bimbingan->persetujuanPembimbing2 ? $bimbingan->persetujuanPembimbing2->status : '-' }}</td>
                    <td class="{{ $bimbingan->status === 'disetujui' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $bimbingan->status }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada bimbingan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
