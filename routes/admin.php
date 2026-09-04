<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CardApplicationAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SitePageController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Redirect old /mgt and /mgt/login URLs to /admin / admin/login
Route::get('/mgt/login', function () {
    return redirect()->route('admin.login');
});
Route::any('/mgt', function () {
    return auth()->check() ? redirect()->route('admin.dashboard') : redirect()->route('admin.login');
});
Route::any('/mgt/{any}', function () {
    return auth()->check() ? redirect()->route('admin.dashboard') : redirect()->route('admin.login');
})->where('any', '.*');

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

        // Card Requests & Quotes (Self-Service Onboarding & 1-Click Provisioning)
        Route::get('/applications', [CardApplicationAdminController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [CardApplicationAdminController::class, 'show'])->name('applications.show');
        Route::post('/applications/{application}/approve', [CardApplicationAdminController::class, 'approve'])->name('applications.approve');
        Route::post('/applications/{application}/reject', [CardApplicationAdminController::class, 'reject'])->name('applications.reject');

        // Tenant Switcher
        Route::post('/organizations/switch/{organization}', [OrganizationController::class, 'switchTenant'])->name('organizations.switch');

        // Organizations Management
        Route::post('/organizations/invite', [OrganizationController::class, 'createInvitation'])->name('organizations.invite');
        Route::resource('organizations', OrganizationController::class);
        Route::post('/organizations/{organization}/members', [OrganizationController::class, 'addMember'])->name('organizations.members.add');
        Route::delete('/organizations/{organization}/members/{user}', [OrganizationController::class, 'removeMember'])->name('organizations.members.remove');

        // Home Page Sections & Visual Builder
        Route::get('/home-sections', [HomePageController::class, 'index'])->name('home-sections.index');
        Route::post('/home-sections/update', [HomePageController::class, 'updateSection'])->name('home-sections.update');
        Route::post('/home-sections/slides/save', [HomePageController::class, 'saveSlide'])->name('home-sections.slides.save');
        Route::delete('/home-sections/slides/delete/{index}', [HomePageController::class, 'deleteSlide'])->name('home-sections.slides.delete');

        // Leadership Team Management
        Route::resource('team', TeamController::class)->except(['show']);
        Route::post('/team/quick-store', [TeamController::class, 'quickStore'])->name('team.quick-store');
        Route::post('/team/quick-update/{team}', [TeamController::class, 'quickUpdate'])->name('team.quick-update');
        Route::post('/team/toggle-status/{team}', [TeamController::class, 'toggleStatus'])->name('team.toggle-status');

        // Services Management
        Route::resource('services', ServiceController::class)->except(['show']);

        // Portfolio / Projects Management
        Route::resource('portfolio', PortfolioController::class)->except(['show']);

        // Built-in website pages
        Route::get('/site-settings', [SiteSettingsController::class, 'index'])->name('site-settings.index');
        Route::post('/site-settings', [SiteSettingsController::class, 'update'])->name('site-settings.update');
        Route::get('/site-pages/{page}', [SitePageController::class, 'edit'])->name('site-pages.edit');
        Route::post('/site-pages/{page}', [SitePageController::class, 'update'])->name('site-pages.update');

        // Custom Pages
        Route::resource('pages', PageController::class)->except(['show']);

        // Navigation Menus
        Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
        Route::post('/menus/locations', [MenuController::class, 'storeMenu'])->name('menus.locations.store');
        Route::delete('/menus/locations/{menu}', [MenuController::class, 'destroyMenu'])->name('menus.locations.destroy');
        Route::post('/menus/items', [MenuController::class, 'storeItem'])->name('menus.items.store');
        Route::put('/menus/items/{item}', [MenuController::class, 'updateItem'])->name('menus.items.update');
        Route::delete('/menus/items/{item}', [MenuController::class, 'destroyItem'])->name('menus.items.destroy');

        // Social Media
        Route::resource('socials', SocialController::class)->except(['show', 'create', 'edit']);

        // Platform Users & Staff
        Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);
    });
});
