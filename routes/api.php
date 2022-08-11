<?php

use App\Http\Controllers\DetailMovieController;
use App\Http\Controllers\LinkMovieController;
use App\Http\Controllers\StandardField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API STANDARD FIELD
Route::get('/standard-field/{id}',[StandardField::class, 'findOne'])->name('api.standard_field');
Route::get('/standard-field-ajax/{id}',[StandardField::class, 'findOneAjax'])->name('api.standard_field_ajax');
Route::get('/standard-field-detail-ajax/{id}',[StandardField::class, 'findOneResolution'])->name('api.standard_field_detail_ajax');

// API MOVIE
Route::get('/detail-movie/{id}',[DetailMovieController::class, 'apiIndex'])->name('api.detail_movie_index');
Route::get('/detail-id/{id}',[DetailMovieController::class, 'findOne'])->name('api.detail_id');
Route::get('/link-id/{id}',[LinkMovieController::class, 'apiIndex'])->name('api.link_movie');
