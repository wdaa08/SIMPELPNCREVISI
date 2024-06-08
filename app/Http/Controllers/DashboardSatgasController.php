<?php

namespace App\Http\Controllers;

use App\Models\Pelaporan;
use Illuminate\Http\Request;

class DashboardSatgasController extends Controller
{
    public function index() {
        // $tabellaporan = Pelaporan::all();
        // return view('satgas.dashboard', compact('tabellaporan'));
        // Mengambil data pelaporan beserta nilai tanda_tangan dari tabel users
    $tabellaporan = Pelaporan::select(
        'pelaporans.*', // Mengambil semua kolom dari tabel pelaporans
        'users.tanda_tangan' // Mengambil nilai tanda_tangan dari tabel users
    )
    ->join('users', 'pelaporans.user_id', '=', 'users.id') // Melakukan join antara tabel pelaporans dan users berdasarkan user_id
    ->get();

    return view('layouts.tampilanpelapor', compact('tabellaporan'));
    }
}
