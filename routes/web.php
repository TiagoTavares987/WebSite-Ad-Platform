<?php

use App\Http\Controllers\Anuncios\AnuncioController;
use App\Http\Controllers\Anuncios\AnunciosController;
use App\Http\Controllers\Base\HomeController;
use App\Http\Controllers\Compras\CompraController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Relatorio\RelatorioController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AnunciosController::class, 'index'])->name('root');

Auth::routes(['verify' => true]);

Route::get('/verification', ['uses' => function () {
    // verificar se a sessao tem uma verificacao
    if(session()->has('verification'))
    {
        $verification = session()->get('verification');
        
        if($verification != null && is_array($verification) && array_key_exists('title', $verification) && array_key_exists('message', $verification))
        return view('auth.verification', $verification);
    }        
    return redirect()->route('root');
 }])->name('verification');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::post('/users', [UsersController::class, 'update'])->name('users');

Route::get('/user', [UserController::class, 'index'])->name('user');
Route::post('/user', [UserController::class, 'update'])->name('user');

Route::get('/ads', [AnunciosController::class, 'index'])->name('ads');
Route::post('/ads/search', [AnunciosController::class, 'search'])->name('ads.search');
Route::post('/ads/sort', [AnunciosController::class, 'sort'])->name('ads.sort');

Route::get('/ad', [AnunciosController::class, 'adView'])->name('ad');

Route::post('/ad/buy', [AnuncioController::class, 'buy'])->name('ad.buy');

Route::get('/ad/edit', [AnuncioController::class, 'edit'])->name('ad.edit');
Route::post('/ad/create', [AnuncioController::class, 'create'])->name('ad.create');
Route::post('/ad/update', [AnuncioController::class, 'update'])->name('ad.update');
Route::post('/ad/delete', [AnuncioController::class, 'delete'])->name('ad.delete');

Route::post('/payment', [CompraController::class, 'payment'])->name('payment');
Route::post('/buy', [CompraController::class, 'buy'])->name('buy');

Route::get('/report/ads', [RelatorioController::class, 'ads'])->name('report.ads');
Route::get('/report/sales', [RelatorioController::class, 'sales'])->name('report.sales');
Route::get('/report/buys', [RelatorioController::class, 'buys'])->name('report.buys');

// Route::controller(CompraController::class)->group(function(){
//     Route::post('payment', 'payment')->name('payment');
//     Route::post('buy', 'buy')->name('buy');
// });

