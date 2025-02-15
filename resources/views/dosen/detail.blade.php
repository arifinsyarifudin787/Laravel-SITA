@extends('layouts.main')

@section('container')
    <div class="flex flex-col items-center justify-center h-screen">
        <h2 class="mb-4 text-3xl font-bold">Bimbingan Mahasiswa</h2>
        <p>{{ $mahasiswa->name }}</p>

        @forelse ($mahasiswa->bimbingans as $bimbingan)
            <p> 
                {{ $bimbingan->tanggal_bimbingan }} 
                <b>{{ $bimbingan->status }}</b>
            </p>
        @empty
            <p class="text-gray-500">Belum ada bimbingan.</p>
        @endforelse

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">Logout</button>
        </form>
    </div>
@endsection
