@extends('layouts.main')

@section('container')
    <div class="main-content">
        <div class="flex flex-col items-center justify-center">
            <h2 class="mb-4 text-3xl font-bold">Data Bimbingan</h2>
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
                <table class="table-auto w-full md:w-3/4 lg:w-2/3 border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Tanggal Bimbingan</th>
                            <th class="border px-4 py-2">Deskripsi</th>
                            <th class="border px-4 py-2">Dosen 1</th>
                            <th class="border px-4 py-2">Dosen 2</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bimbingans as $index => $bimbingan)
                            <tr class="border">
                                <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2 text-center">
                                    {{ $bimbingan->tanggal() ?? '-' }}
                                </td>
                                <td class="border px-4 py-2">{!! nl2br(e($bimbingan->deskripsi)) !!}</td>
                                <td class="border px-4 py-2 text-center">
                                    {{ optional($bimbingan->persetujuanPembimbing1)->status ?? '-' }}
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    {{ optional($bimbingan->persetujuanPembimbing2)->status ?? '-' }}
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <b class="{{ $bimbingan->status === 'disetujui' ? 'text-green-600' : ($bimbingan->status === 'ditolak' ? 'text-red-600' : '')}}">
                                        {{ $bimbingan->status }}
                                    </b>
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    @if ($bimbingan->persetujuans->every(fn($p) => $p->status === 'diajukan'))
                                    <form action="{{ route('bimbingan.destroy', $bimbingan->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-red">Hapus</button>
                                    </form>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center border px-4 py-2">Belum ada bimbingan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
