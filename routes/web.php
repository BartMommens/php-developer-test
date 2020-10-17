<?php


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

Route::get('/', [App\Http\Controllers\PictureController::class, 'index'])->name('index');
Route::get('/detail/{id}', [App\Http\Controllers\PictureController::class, 'view_detail'])->name('detail');

Route::post('/like', [App\Http\Controllers\LikeController::class, 'like_picture'])->name('like');
