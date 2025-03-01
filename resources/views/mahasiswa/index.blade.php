@extends('layouts.main')

@section('container')
    <div class="main-content">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <h2 class="mb-4 text-3xl font-bold">Dashboard</h2>

            <!-- Tabel Bimbingan -->
            <div class="w-full px-4 md:px-0 overflow-x-auto">
                <table class="table-auto w-full md:w-3/4 lg:w-2/3">
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
                        @forelse ($bimbingans as $index => $bimbingan)
                            <tr>
                                <td>{{ $index + 1 }}</td> 
                                <td>{{ $bimbingan->tanggal() }}</td>
                                <td>{{ $bimbingan->deskripsi }}</td>
                                <td>{{ $bimbingan->persetujuanPembimbing1() ? $bimbingan->persetujuanPembimbing1()->status : '-' }}</td>
                                <td>{{ $bimbingan->persetujuanPembimbing2() ? $bimbingan->persetujuanPembimbing2()->status : '-' }}</td>
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
    </div>
@endsection
