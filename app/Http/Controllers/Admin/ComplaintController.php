<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    // List semua complain (masih kosong / stub)
    public function index()
    {
        // nanti akan mengambil complain dari database
        $complains = []; 

        return view('admin.complain.index', compact('complains'));
    }

    // Lihat detail complain (nanti diarahkan ke chat)
    public function show($id)
    {
        // nanti diarahkan ke halaman chat complain
        return view('admin.complain.show', ['id' => $id]);
    }

    // Sementara tidak ada action lain
}
