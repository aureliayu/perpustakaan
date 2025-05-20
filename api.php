<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\siswacontroller;
use App\Http\Controllers\kelascontroller;
use App\Http\Controllers\bukucontroller;
use App\Http\Controllers\gurucontroller;
use App\Http\Controllers\Transaksicontroller;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getsiswa', [siswacontroller::class,'getsiswa']);
Route::post('/addsiswa', [siswacontroller::class,'addsiswa']);
Route::put('/updatesiswa/{id}', [siswacontroller::class,'updatesiswa']);    
Route::get('/getsiswaid/{id}',[siswacontroller::class,'getsiswaid']);
Route::delete('/deletesiswa/{id}',[siswacontroller::class,'deletesiswa']);

Route::get('/getkelas', [kelascontroller::class,'getkelas']);
Route::post('/addkelas', [kelascontroller::class,'addkelas']);
Route::put('/updatekelas/{id}', [kelascontroller::class,'updatekelas']);    
Route::get('/getkelasid/{id}',[kelascontroller::class,'getkelasid']);
Route::delete('/deletekelas/{id}',[kelascontroller::class,'deletekelas']);

Route::get('/getbuku', [bukucontroller::class,'getbuku']);    
Route::post('/addbuku', [bukucontroller::class,'addbuku']);
Route::put('/updatebuku/{id}', [bukucontroller::class,'updatebuku']);    
Route::get('/getbukuid/{id}',[bukucontroller::class,'getbukuid']);
Route::delete('/deletebuku/{id}',[bukucontroller::class,'deletebuku']);

Route::get('/getguru', [gurucontroller::class,'getguru']);
Route::post('/pinjam', [Transaksicontroller::class,'pinjamBuku']);
Route::post('/kembali', [Transaksicontroller::class,'PengembalianBuku']);

// Route::post('/pinjamBuku','transaksicontoller@pinjamBuku',);

Route::post('tambah_item/{id}','transaksicontroller@tambahitem');

//auth
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});