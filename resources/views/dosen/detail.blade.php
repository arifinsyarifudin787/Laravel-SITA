@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="flex flex-col items-center justify-center h-screen">
        <h2 class="mb-4 text-3xl font-bold">Bimbingan Mahasiswa</h2>

        <!-- Tabel Detail Bimbingan -->
        <table class="table-auto border-collapse border border-gray-400 mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-400 px-4 py-2">No</th>
                    <th class="border border-gray-400 px-4 py-2">Nama Mahasiswa</th>
                    <th class="border border-gray-400 px-4 py-2">Tanggal Bimbingan</th>
                    <th class="border border-gray-400 px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @forelse ($mahasiswa->bimbingans as $bimbingan)
                    <tr>
                        <td class="border border-gray-400 px-4 py-2 text-center">{{ $no++ }}</td>
                        <td class="border border-gray-400 px-4 py-2 text-center">{{ $mahasiswa->name }}</td>
                        <td class="border border-gray-400 px-4 py-2 text-center">{{ $bimbingan->tanggal_bimbingan }}</td>
                        <td class="border border-gray-400 px-4 py-2 text-center">
                        @php
                            $persetujuan = $bimbingan->persetujuans->where('dosen_id', $dosenId)->first();
                        @endphp
                        
                        @if ($persetujuan)
                        <b class="{{ $persetujuan->status == 'Disetujui' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $persetujuan->status }}
                        </b>
                        @else
                        <form action="{{ route('persetujuan.bimbingan') }}" method="POST" class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
                            @csrf
                            <input name="type" value="bimbingan" hidden>
                            <input name="bimbingan" value="{{ $bimbingan->id }}" hidden>
                            <button type="submit" name="status" value="disetujui" class="btn btn-green">✅ Setujui</button>
                            <button type="submit" name="status" value="ditolak" class="btn btn-red">❌ Tolak</button>
                        </form>
                        @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="border border-gray-400 px-4 py-2 text-center text-gray-500">
                            Belum ada bimbingan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
