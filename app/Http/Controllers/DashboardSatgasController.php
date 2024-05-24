<?php

namespace App\Http\Controllers;

use App\Models\Pelaporan;
use Illuminate\Http\Request;

class DashboardSatgasController extends Controller
{
    public function index() {
        $tabellaporan = Pelaporan::all();
        return view('satgas.dashboard', compact('tabellaporan'));
    }
}
