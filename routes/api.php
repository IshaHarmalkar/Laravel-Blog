<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\FileUploadController;


Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
Route::post('/blogs', [BlogController::class, 'store'])->name('blog.store');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blog.update');
Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');



// File Upload Routes
Route::get('/uploads', [FileUploadController::class, 'index'])->name('uploads.index');
Route::post('/uploads', [FileUploadController::class, 'store'])->name('uploads.store');
Route::get('/uploads/{fileUpload}', [FileUploadController::class, 'show'])->name('uploads.show');
Route::put('/uploads/{fileUpload}', [FileUploadController::class, 'update'])->name('uploads.update');
Route::delete('/uploads/{fileUpload}', [FileUploadController::class, 'destroy'])->name('uploads.destroy');


Route::post('/register', function () {
    return redirect()->route('register'); // Redirect to the 'register' route in auth.php
});