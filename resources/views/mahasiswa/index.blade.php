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
                            <th>Nama</th>
                            <th>Judul TA</th>
                            <th>Tanggal Bimbingan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($bimbingans->isNotEmpty())
                            @foreach ($bimbingans as $index => $bimbingan)
                                <tr>
                                    <td>{{ $index + 1 }}</td> 
                                    <td>{{ auth()->user()->name }}</td>
                                    <td>{{ $tugas_akhir->judul }}</td>
                                    <td>{{ $bimbingan->tanggal_bimbingan }}</td>
                                    <td class="{{ $bimbingan->status === 'disetujui' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $bimbingan->status }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data bimbingan</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
