<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/our-services', function () {
    return view('services');
})->name('services');

Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('service.show');
