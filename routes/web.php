<?php

use App\Models\Organization;
use App\Models\OrganizationContact;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $address = Organization::first()->address;
    $email = OrganizationContact::where('type', 'email')->first()->value ?? null;
    $phone = OrganizationContact::where('type', 'phone')->first()->value ?? null;
    $data = ['email' => $email, 'phone' => $phone];
    return view('index', compact('address', 'data'));
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
