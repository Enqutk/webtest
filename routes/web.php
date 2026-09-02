<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

// 1. Reception / Main Platform Landing Page (Kimem Cards Luxury Showcase)
Route::get('/', function () {
    return view('kimem-landing');
})->name('home');

Route::get('/cards', function () {
    return view('kimem-landing');
})->name('kimem.cards');

// 2. Client Company / Tenant Websites (/card/{slug} or /org/{slug})
Route::prefix('card/{slug}')->name('card.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/our-services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/{service_slug}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
    Route::get('/portfolio/{entity}', [PortfolioController::class, 'show'])->name('portfolio.show');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact/send/{recipient}', [ContactController::class, 'send'])
        ->middleware('throttle:contact')
        ->name('contact.send');
    Route::get('/pages/{page_slug}', [PageController::class, 'show'])
        ->where('page_slug', '[A-Za-z0-9\-]+')
        ->name('pages.show');
});

// Alias for /org/{slug} -> /card/{slug}
Route::get('/org/{slug}', function (string $slug) {
    return redirect()->route('card.home', ['slug' => $slug]);
})->name('org.home');

// 3. Fallback / Custom Domain Routes (when mapped to custom domain directly)
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/our-services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{entity}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send/{recipient}', [ContactController::class, 'send'])
    ->middleware('throttle:contact')
    ->name('contact.send');
Route::get('/pages/{slug}', [PageController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('pages.show');
