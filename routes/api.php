<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\GreetController;
use App\Http\Controllers\GalleryControllerAPI;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/info', [InfoController::class, 'index'])->name('info');
Route::get('/greet', [GreetController::class, 'greet'])->name('greet');
Route::post('/apigallery', [GalleryControllerAPI::class, 'store'])->name('galleryapi.store');
Route::get('/apigallery', [GalleryControllerAPI::class, 'index'])->name('galleryapi.index');
Route::get('/getgallery', [GalleryControllerAPI::class, 'get'])->name('galleryapi.get');