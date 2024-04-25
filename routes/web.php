<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\GoogleDriveController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/upload', [ImageController::class, 'create']);
Route::post('/upload', [ImageController::class, 'store']);
Route::get('/gallery', [ImageController::class, 'gallery']);
Route::put('/image/{id}', [ImageController::class, 'update'])->name('image.update');
Route::get('/drive', [GoogleDriveController::class, 'listFiles']);
