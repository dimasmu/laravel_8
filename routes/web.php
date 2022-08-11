<?php

use App\Http\Controllers\DetailMovieController;
use App\Http\Controllers\LinkMovieController;
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
Route::prefix('/detail-movie')->group(function(){
    route::get('/{id}',[DetailMovieController::class, 'index'])->name('detail_movie.index');
    route::post('/',[DetailMovieController::class, 'insert'])->name('detail_movie.save');
    route::delete('/{id}',[DetailMovieController::class, 'delete'])->name('detail_movie.delete');
});

//MOVIE LINK ROUTE
Route::prefix('/link')->group(function(){
    route::get('/{id}',[LinkMovieController::class, 'index'])->name('link.index');
    route::get('/open-link/{id}',[LinkMovieController::class, 'findOne'])->name('link.findOne');
    route::post('/{id}',[LinkMovieController::class, 'save'])->name('link.save');
    route::delete('/{id}',[LinkMovieController::class, 'delete'])->name('link.delete');
});
