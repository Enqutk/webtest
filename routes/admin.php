<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TeamController;
use Illuminate\Support\Facades\Route;

// Admin Guest Routes (Login)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Admin Authenticated Routes
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Tenant Switcher
        Route::post('/organizations/switch/{organization}', [OrganizationController::class, 'switchTenant'])->name('organizations.switch');

        // Organizations Management
        Route::resource('organizations', OrganizationController::class);
        Route::post('/organizations/{organization}/members', [OrganizationController::class, 'addMember'])->name('organizations.members.add');
        Route::delete('/organizations/{organization}/members/{user}', [OrganizationController::class, 'removeMember'])->name('organizations.members.remove');

        // Home Page Sections & Visual Builder
        Route::get('/home-sections', [HomePageController::class, 'index'])->name('home-sections.index');
        Route::post('/home-sections/update', [HomePageController::class, 'updateSection'])->name('home-sections.update');
        Route::post('/home-sections/slides/save', [HomePageController::class, 'saveSlide'])->name('home-sections.slides.save');
        Route::delete('/home-sections/slides/delete/{index}', [HomePageController::class, 'deleteSlide'])->name('home-sections.slides.delete');

        // Leadership Team Management (Modal & Standard CRUD)
        Route::resource('team', TeamController::class)->except(['show']);
        Route::post('/team/quick-store', [TeamController::class, 'quickStore'])->name('team.quick-store');
        Route::post('/team/quick-update/{team}', [TeamController::class, 'quickUpdate'])->name('team.quick-update');
        Route::post('/team/toggle-status/{team}', [TeamController::class, 'toggleStatus'])->name('team.toggle-status');

        // Services Management
        Route::resource('services', ServiceController::class)->except(['show']);

        // Portfolio / Projects Management
        Route::resource('portfolio', PortfolioController::class)->except(['show']);
    });
});
