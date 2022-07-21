<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieListController;
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

Route::get('/', function () {
    return view('welcome');
});

//MOVIE ROUTE
Route::get('/movie',[MovieListController::class, 'index'])->name('movie');
Route::get('/open-movie',[MovieListController::class, 'openMovie'])->name('open_movie');
Route::post('/insert-movie',[MovieListController::class, 'insertMovie'])->name('insert_movie');
Route::get('/update-movie/{id}',[MovieListController::class, 'updateMovie'])->name('update_movie');
Route::get('/delete-movie/{id}',[MovieListController::class, 'deleteMovie'])->name('delete_movie');

//MOVIE DETAIL ROUTE
