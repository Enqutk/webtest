<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact/send/{recipient}', [ContactController::class, 'send'])->name('contact.send');

Route::get('/our-services', function () {
    return view('services');
})->name('services');
