@extends('layouts.main')

@section('container')
    <div class="flex flex-col items-center justify-center h-screen">
        <h2 class="mb-4 text-3xl font-bold">Dashboard</h2>
        <p>{{ auth()->user()->name }}</p>
        @foreach ($tugas_akhirs as $ta)
        <span> {{ $ta->mahasiswa->name }} {{ $ta->judul }}
            <a href="/tugas-akhir/{{ $ta->id }}">Detail</a>
        </span>
        <br>
        @endforeach
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">Logout</button>
        </form>
    </div>
@endsection
