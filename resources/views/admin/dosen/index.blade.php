@extends('layouts.main')

@section('container')
<div class="main-content">
    <div class="flex flex-col items-center justify-center">
        <h2 class="mb-4 text-3xl font-bold">Data Dosen Luar</h2>
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

            <div class="info-container justify-between">
                <a href="{{ route('dosen.create') }}" class="bttn btn-add">Tambah Dosen Luar</a>
                <span>Jumlah Dosen Luar: {{ $dosens->count() }}</span>
            </div>
            
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Dosen</th>
                    <th>Asal PT</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dosens as $dosen)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dosen->username }}</td>
                        <td>{{ $dosen->name }}</td>
                        <td>{{ $dosen->asal_pt }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('dosen.edit', $dosen->id) }}" class="bttn btn-edit">Edit</a>
                                <form id="delete-dosen-{{ $dosen->id }}" action="{{ route('dosen.destroy', $dosen->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" class="bttn btn-archive" onclick="confirmDelete(`delete-dosen-{{ $dosen->id }}`)">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data dosen luar</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
