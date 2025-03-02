@extends('layouts.main')

@section('container')
    <div class="main-content">
        <div class="flex flex-col items-center justify-center min-h-screen">
            <h2 class="mb-4 text-3xl font-bold">Dashboard</h2>

            <!-- Flash Message -->
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-200 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Tabel Bimbingan -->
            <div class="w-full px-4 md:px-0 overflow-x-auto">
                <table class="table-auto w-full md:w-3/4 lg:w-2/3 border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Tanggal Bimbingan</th>
                            <th class="border px-4 py-2">Deskripsi</th>
                            <th class="border px-4 py-2">Dosen 1</th>
                            <th class="border px-4 py-2">Dosen 2</th>
                            <th class="border px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bimbingans as $index => $bimbingan)
                            <tr class="border">
                                <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2 text-center">
                                    {{ $bimbingan->tanggal() ?? '-' }}
                                </td>
                                <td class="border px-4 py-2">{{ $bimbingan->deskripsi }}</td>
                                <td class="border px-4 py-2 text-center">
                                    {{ optional($bimbingan->persetujuanPembimbing1)->status ?? '-' }}
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    {{ optional($bimbingan->persetujuanPembimbing2)->status ?? '-' }}
                                </td>
                                <td class="border px-4 py-2 text-center {{ $bimbingan->status === 'disetujui' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $bimbingan->status }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center border px-4 py-2">Belum ada bimbingan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
