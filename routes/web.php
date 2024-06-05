<?php

use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardSatgasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelaporanController;
// use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isLogin;
use App\Models\Pelaporan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//landingpage

Route::get('/', function () {
    return view('landingpage/index');
});

Route::get('landingpage/about', function () {
    return view('chatbot');
});




//regiss
Route::get('/register', [RegistrationController::class, 'create'])->name('register');
Route::post('/register', [RegistrationController::class, 'store']);

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/actionlogin', [LoginController::class, 'actionLogin'])->name('actionlogin');
Route::post('/actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');

Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/actionlogin', [LoginController::class, 'actionLogin'])->name('actionlogin')->middleware('guest');
Route::post('/actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');




Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile');
Route::put('/profile/{id}', [UserController::class, 'updateprofile'])->name('updateprofile');

Route::prefix('satgas')->middleware('check.role:1')->group(function () {
    // Route::get('/datapelaporan', [DashboardSatgasController::class, 'index'])->name('s.dashboard');
    Route::get('/datapelaporan', [PelaporanController::class, 'datapelaporan'])->name('s.datapelaporan');
    Route::get('/datapelaporan/{id}/edit', [PelaporanController::class, 'editdatapelaporan'])->name('s.editdatapelaporan');
    Route::put('/datapelaporan/{id}/edit', [PelaporanController::class, 'updatedatapelaporan'])->name('s.updatedatapelaporan');
    Route::get('/datapengguna', [UserController::class, 'datapengguna'])->name('s.datapengguna');
    Route::get('/datapelaporan/{id}', [PelaporanController::class, 'ttdview'])->name('ttdview');
    Route::get('/datapelaporan/{id}', [PelaporanController::class, 'ttdview'])->name('ttdview');

    // Tambahkan rute lain dalam grup ini

    //route pencarian
    Route::get('/datapelaporan/search', [PelaporanController::class, 'search'])->name('s.datapelaporan.search');
});

Route::prefix('pelapor')->middleware('check.role:2')->group(function () {
    Route::post('/tambah_laporan', [PelaporanController::class, 'store'])->name('tambah_laporan');
    Route::get('/halamanpelaporan', [PelaporanController::class, 'index'])->name('p.halamanpelaporan');
    Route::get('/halamanpelaporan/pelaporan', [PelaporanController::class, 'pelaporan'])->name('pelaporan');
    Route::get('/halamanpelaporan/laporan_saya', [PelaporanController::class, 'laporansaya'])->name('laporansaya');
    Route::get('/halamanpelaporan/laporan_saya/{id}/edit', [PelaporanController::class, 'editlaporan'])->name('editlaporan');
    Route::put('/halamanpelaporan/laporan_saya/{id}', [PelaporanController::class, 'updatelaporan'])->name('updatelaporan');

    // Tambahkan rute lain dalam grup ini
});


///chabtbot
Route::get('/chatbot', function () {
    return view('chatbot');
});

Route::post('/chatbot/query', [ChatbotController::class, 'query'])->name('chatbot.query');
Route::post('/chatbot/store', [ChatbotController::class, 'store'])->name('chatbot.store');

Route::get('/add_question', function () {
    return view('add_question');
});
