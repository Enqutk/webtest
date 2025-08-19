<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/our-services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send/{recipient}', [ContactController::class, 'send'])->name('contact.send');



// Test email route (remove in production)
Route::get('/test-email', function () {
    try {
        Mail::raw('Test email from Veritas Afrika website', function ($message) {
            $message->to('contact@veritasafrika.com')
                   ->subject('Test Email - Website Configuration')
                   ->from('contact@veritasafrika.com', 'Veritas Afrika Website');
        });
        return 'Test email sent successfully!';
    } catch (\Exception $e) {
        return 'Email test failed: ' . $e->getMessage();
    }
});

