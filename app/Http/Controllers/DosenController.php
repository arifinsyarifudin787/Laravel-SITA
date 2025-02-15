<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        return view('dosen.index', [
            'title' => 'Dashboard',
        ]);
    }

    public function show()
    {
        return view('dosen.detail', [
            'title' => 'Bimbingan Mahasiswa',
        ]);
    }

    public function store()
    {

    }
}
