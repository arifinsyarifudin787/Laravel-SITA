@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="flex flex-col items-center justify-center">
        <h2 class="mb-4 text-3xl font-bold">Dashboard</h2>
        <table class="table-auto">
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
            <div class="info-container">
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

                <div class="justify-between">
                    <div>
                        <form action="{{ route('dashboard') }}" method="GET">
                            <label for="status" class="text-gray-700 font-medium">Filter Status:</label>
                            <select name="status" id="status" class="filter" onchange="this.form.submit()">
                                <option value="diajukan" {{ $status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="disetujui" {{ $status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
                    </div>

                    <a href="{{ route('ta.export', ['status' => $status]) }}" class="bttn btn-download">
                        Unduh Laporan
                    </a>
                </div>
            </div>
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
                                $progress = min(100, $totalBimbingan > 0 ? ($totalBimbingan / 16 * 100) : 0);
                            @endphp
                            {{ number_format($progress, 1) }}%
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('ta.show', $ta->id) }}" class="bttn btn-detail">Detail</a>
                                @if ($progress === 0)
                                <a href="{{ route('ta.edit', $ta->id) }}" class="bttn btn-edit">Edit</a>
                                @endif
                                @if ($ta->status === 'disetujui')
                                <form action="{{ route('ta.destroy', $ta->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="bttn btn-archive">Arsipkan</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada Tugas Akhir</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if ($tugas_akhirs)
        <div class="pagination">
            {{ $tugas_akhirs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
