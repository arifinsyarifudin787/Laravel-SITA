@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="flex flex-col items-center justify-center">
        <h2 class="mb-4 text-3xl font-bold">{{ $mahasiswa->name }}</h2>

        <!-- Tabel Detail Bimbingan -->
        <table class="table-auto border-collapse border border-gray-400 mt-4">
            <div class="info-container">
                Judul TA: <b><i>{{ $mahasiswa->tugasAkhir->judul ?? '-' }}</i></b>
                <br>
                @foreach ($mahasiswa->pembimbings as $index => $p)
                <br>
                Pembimbing {{ $index + 1 }}: {{ $p->name }}
                @endforeach
            </div>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Bimbingan</th>
                    <th>Materi</th>
                    <th>Dosen 1</th>
                    <th>Dosen 2</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mahasiswa->bimbingans as $bimbingan)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td> 
                    <td class="text-center">{{ $bimbingan->tanggal() }}</td>
                    <td class="justify-text">{{ $bimbingan->materi }}</td>
                    <td class="text-center">{{ $bimbingan->persetujuanPembimbing1 ? $bimbingan->persetujuanPembimbing1->status : '-' }}</td>
                    <td class="text-center">{{ $bimbingan->persetujuanPembimbing2 ? $bimbingan->persetujuanPembimbing2->status : '-' }}</td>
                    <td class="text-center">
                        <b class="{{ $bimbingan->status === 'disetujui' ? 'text-green-600' : ($bimbingan->status === 'ditolak' ? 'text-red-600' : '')}}">
                            {{ $bimbingan->status }}
                        </b>
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
