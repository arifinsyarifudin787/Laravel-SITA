@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="flex flex-col items-center justify-center">
        <h2 class="mb-4 text-3xl font-bold">Pencarian: {{ $nama }}</h2>
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
            
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Progress</th>
                    <th>Status</th>
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
                                $totalBimbingan = 0;
                                foreach ($ta->mahasiswa->pembimbings as $p) {
                                    $bimbingans = optional($ta->mahasiswa)->bimbingans->sum(
                                        fn($bimbingan) => $bimbingan->persetujuans->where('dosen_id', $p->id)->count()
                                    );
                                    $bimbingans = $bimbingans > 8 ? 8 : $bimbingans;
                                    $totalBimbingan += $bimbingans;
                                }
                                $progress = $totalBimbingan / 16 * 100;
                            @endphp
                            {{ number_format($progress, 1) }}%
                        </td>
                        <td>{{ $ta->status }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('ta.show', $ta->id) }}" class="bttn btn-detail">Detail</a>
                                @if ($progress === 0)
                                <a href="{{ route('ta.edit', $ta->id) }}" class="bttn btn-edit">Edit</a>
                                @endif
                                @if ($ta->status === 'disetujui')
                                <form id="archive-ta-{{ $ta->id }}" action="{{ route('ta.destroy', $ta->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" class="bttn btn-archive" onclick="confirmArchive(`archive-ta-{{ $ta->id }}`)">Arsipkan</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada Tugas Akhir</td>
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
