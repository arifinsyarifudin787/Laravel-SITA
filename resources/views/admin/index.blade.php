@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="flex flex-col items-center justify-center h-screen">
        <h2 class="mb-4 text-3xl font-bold">Dashboard Admin</h2>
        <p class="mb-6">Selamat datang, {{ auth()->user()->name }}</p>

        <!-- Tabel Tugas Akhir -->
        <table class="table-auto">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Judul Tugas Akhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tugas_akhirs as $ta)
                    <tr>
                        <td>{{ $ta->mahasiswa->name }}</td>
                        <td>{{ $ta->judul }}</td>
                        <td>
                            <a href="/tugas-akhir/{{ $ta->id }}" class="btn-detail">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada Tugas Akhir</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection