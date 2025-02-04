<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;


Route::get('/blogs', [BlogController::class, 'index'])->name('blog.index');
Route::post('/blogs', [BlogController::class, 'store'])->name('blog.store');
Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blog.show');
Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blog.update');
Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blog.destroy');

