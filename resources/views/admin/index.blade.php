@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="flex flex-col items-center justify-center h-screen">
        <h2 class="mb-4 text-3xl font-bold">Dashboard Admin</h2>
        <p class="mb-6">Selamat datang, {{ auth()->user()->name }}</p>

        <!-- Kartu Statistik -->
        <div class="card-container">
            <div class="card blue">
                <h3>On Going</h3>
                <p>{{ $countDiajukan }}</p>
            </div>
            <div class="card green">
                <h3>Siap Sidang</h3>
                <p>{{ $countDisetujui }}</p>
            </div>
            <div class="card gray">
                <h3>Selesai</h3>
                <p>{{ $countSelesai }}</p>
            </div>
        </div>

        <!-- Filter -->
        <form action="{{ route('dashboard') }}" method="GET" class="mb-4">
            <label for="status" class="mr-2">Filter Status:</label>
            <select name="status" id="status" onchange="this.form.submit()">
                <option value="diajukan" {{ $status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="disetujui" {{ $status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </form>

        <a href="{{ route('ta.export', ['status' => $status]) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
            Buat Laporan
        </a>

        <!-- Tabel Tugas Akhir -->
        <table class="table-auto">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Progress</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tugas_akhirs as $ta)
                    <tr>
                        <td>{{ $ta->nim }}</td>
                        <td>{{ optional($ta->mahasiswa)->name ?? '-' }}</td>
                        <td>
                            @php
                                $totalBimbingan = optional($ta->mahasiswa)->bimbingans->sum(fn($bimbingan) => $bimbingan->persetujuans->count()) ?? 0;
                                $progress = $totalBimbingan > 0 ? ($totalBimbingan / 16 * 100) : 0;
                            @endphp
                            {{ number_format($progress, 1) }}%
                        </td>
                        <td>
                            <a href="/tugas-akhir/{{ $ta->id }}" class="btn-detail">Detail</a>
                            @if ($ta->status === 'disetujui')
                            <form action="{{ route('ta.update', $ta->id) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="btn btn-red">Arsipkan</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada Tugas Akhir</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
