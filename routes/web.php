<?php

use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardSatgasController;
use App\Http\Controllers\DirekturController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PelaporanController;
// use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isLogin;
use App\Models\Pelaporan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


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


//////////TUJUAN KETIKA WEB DIAKSES///////////
Route::get('/', function () {
    return view('login');
});







//////////LOGIN dan LOGUT///////////
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/actionlogin', [LoginController::class, 'actionLogin'])->name('actionlogin');
Route::post('/actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');

Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/actionlogin', [LoginController::class, 'actionLogin'])->name('actionlogin')->middleware('guest');
Route::post('/actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');



//////////UPDATE PROFIL///////////
Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile');
Route::put('/profile/{id}', [UserController::class, 'updateprofile'])->name('updateprofile');

//////////UPDATE RESPON///////////
Route::post('/pelaporans/{id}/updateRespon', [PelaporanController::class, 'updateRespon'])->name('pelaporans.updateRespon');

Route::get('/pelaporans/{id}', [PelaporanController::class, 'show']);


Route::prefix('satgas')->middleware('check.role:1')->group(function () {

    Route::get('/datapelaporan/{id}/edit', [PelaporanController::class, 'editdatapelaporan'])->name('s.editdatapelaporan');
    Route::put('/datapelaporan/{id}/edit', [PelaporanController::class, 'updatedatapelaporan'])->name('s.updatedatapelaporan');
    
    // Route::get('/datapelaporan', [PelaporanController::class, 'datapelaporan'])->name('datapelaporan');
    Route::get('/addquestion', [ChatbotController::class, 'questionindex'])->name('addquestion');

    Route::get('/datapelaporan', [DashboardSatgasController::class, 'index']);
    Route::get('/datapelaporan/{id}', [DashboardSatgasController::class, 'show']);
    Route::get('/datapelaporan', [DashboardSatgasController::class, 'index'])->name('s.datapelaporan');
    Route::get('/Dashboard', [DashboardSatgasController::class, 'dashboard'])->name('Dashboard');
    


    // cetak pdf detail pelaporan
    Route::get('/pelaporans/{id}/cetak-pdf', [PdfController::class, 'cetakPdf'])->name('pelaporans.cetakPdf');


    Route::get('/datapengguna', [UserController::class, 'datapengguna'])->name('s.datapengguna');
    Route::post('/users/delete-by-year', [UserController::class, 'deleteUsersByYear'])->name('users.deleteByYear');

    Route::post('/users/import', [UserController::class, 'import'])->name('users.import.post');
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');


    Route::get('/dashboard', [DashboardSatgasController::class, 'dashboard'])->name('dashboardsatgas');

    //cetakadatadashboard
    // routes/web.php
    Route::get('/dashboard/pdf', [DashboardSatgasController::class, 'pdf'])->name('dashboard.pdf');

    // Route::post('/pelaporans/{id}/selesai', [PelaporanController::class, 'laporanSelesai'])->name('pelaporans.selesai');


    //search
    Route::get('/users/filter', [UserController::class, 'filter'])->name('users.filter');



    // routes/web.php atau routes/api.php

    Route::post('/send-message', [PelaporanController::class, 'send']);





    // Tambahkan rute lain dalam grup ini

});

Route::prefix('pelapor')->middleware('check.role:2')->group(function () {
    Route::post('/tambah_laporan', [PelaporanController::class, 'store'])->name('tambah_laporan');
    Route::get('/dashboardpelapor', [PelaporanController::class, 'index'])->name('p.dashboardpelapor');
    Route::get('/halamanpelaporan/pelaporan', [PelaporanController::class, 'pelaporan'])->name('pelaporan');
    Route::get('/halamanpelaporan/dashboardpelapor', [PelaporanController::class, 'dashboardpelapor'])->name('dashboardpelapor');
    Route::get('/halamanpelaporan/laporan_saya', [PelaporanController::class, 'laporansaya'])->name('laporansaya');
    Route::get('/halamanpelaporan/laporan_saya/{id}/edit', [PelaporanController::class, 'editlaporan'])->name('editlaporan');
    Route::put('/halamanpelaporan/laporan_saya/{id}', [PelaporanController::class, 'updatelaporan'])->name('updatelaporan');
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
    Route::post('/chatbot/query', [ChatbotController::class, 'query'])->name('chatbot.query');
    

    Route::post('/pelaporans/{id}/selesai', [PelaporanController::class, 'laporanSelesai'])->name('pelaporans.selesai');
    // Tambahkan rute lain dalam grup ini
});


// routes/web.php
Route::middleware(['role:3'])->group(function () {
    // Route::get('/dashboarddirektur', 'DirectorController@index')->name('dashboarddirektur');
    Route::get('/dashboarddirektur', [DirekturController::class, 'index'])->name('d.dashboarddirektur');
    // Route::get('/datalaporanmasuk', [DirekturController::class, 'datalaporanmasuk'])->name('datalaporamasuk');
    Route::get('/datalaporanmasuk', [DirekturController::class, 'datalaporanmasuk'])->name('datalaporanmasuk');
});


Route::post('/chatbot/store', [ChatbotController::class, 'store'])->name('chatbot.store');

Route::get('/add_question', function () {
    return view('add_question');
});


///route cetak pdf
Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);
