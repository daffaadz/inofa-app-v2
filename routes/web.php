<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\RegistrationFlowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RedirectAfterLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Auth By Role
Route::middleware(['auth', 'role:consumer'])
    ->get('/consumer/dashboard', fn() => redirect()->route('dashboard'))
    ->name('consumer.dashboard');

Route::middleware(['auth', 'role:developer'])
    ->get('/developer/dashboard', fn() => redirect()->route('dashboard'))
    ->name('developer.dashboard');

Route::middleware(['auth', 'role:admin'])
    ->get('/admin/dashboard', [DashboardController::class, 'admin'])
    ->name('admin.dashboard');

// Redirect After Login
Route::middleware('auth')
    ->get('/redirect-after-login', RedirectAfterLoginController::class)
    ->name('redirect-after-login');

// Main dashbaord
Route::middleware(['auth'])
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// NEED CHANGE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// socialite authentication
Route::get('/auth/{driver}', [SocialAuthController::class, 'redirect'])
     ->name('social.redirect');

Route::get('/auth/{driver}/callback', [SocialAuthController::class, 'callback'])
     ->name('social.callback');

// Registration flow routes
Route::middleware(['auth'])->group(function () {
    Route::get('/select-role', [RegistrationFlowController::class, 'showRoleSelection'])->name('select-role');
    Route::post('/select-role', [RegistrationFlowController::class, 'storeRole'])->name('select-role.store');

    Route::get('/personal-information', [RegistrationFlowController::class, 'showPersonalInformation'])->name('personal-information');
    Route::post('/personal-information', [RegistrationFlowController::class, 'storePersonalInformation'])->name('personal-information.store');

    Route::get('/developer/information', [RegistrationFlowController::class, 'showDeveloperInformation'])->name('developer.information');
    Route::post('/developer/information', [RegistrationFlowController::class, 'storeDeveloperInformation'])->name('developer.information.store');
});

require __DIR__.'/auth.php';

// CHAT ROUTING
use App\Http\Controllers\Chat\ConversationController;
use App\Http\Controllers\Chat\MessageController;

Route::middleware('auth')->prefix('chat')->group(function () {
    Route::get('conversations', [ConversationController::class, 'index']);
    Route::post('conversations', [ConversationController::class, 'store']);
    Route::get('conversations/{conversation}', [ConversationController::class, 'show']);
    Route::get('conversations/{conversation}/messages', [MessageController::class, 'index']);
    Route::post('conversations/{conversation}/messages', [MessageController::class, 'send']);
    Route::post('conversations/{conversation}/read', [MessageController::class, 'markRead']);
});


// DEVELOPER ROUTING
use App\Http\Controllers\Developer\AgreementController as DevAgreement;
use App\Http\Controllers\Developer\OfferController as DevOffer;
use App\Http\Controllers\Developer\ProjectController as DevProject;
use App\Http\Controllers\Developer\EarningsController as DevEarnings;
use App\Http\Controllers\Developer\SearchController as DevSearch;

Route::middleware(['auth', 'role:developer'])->prefix('developer')->as('developer.')->group(function () {

    /* ---------- Agreements (active / completed) ---------- */
    Route::get('/agreements', [DevAgreement::class, 'index'])
         ->name('agreements.index');
    Route::get('/agreements/{agreement}', [DevAgreement::class, 'show'])
         ->name('agreements.show');

    /* ---------- My Offers (penawaran saya) ---------- */
    Route::get('/offers', [DevOffer::class, 'index'])
         ->name('offers.index');
    Route::delete('/offers/{offer}', [DevOffer::class, 'destroy'])
         ->name('offers.destroy');   // withdraw

    /* ---------- Browse Open Projects ---------- */
    Route::get('/projects', [DevProject::class, 'index'])
         ->name('projects.index');
    Route::get('/projects/{project}', [DevProject::class, 'show'])
         ->name('projects.show');

    /* ---------- Earnings & Payment History ---------- */
    Route::get('/earnings', [DevEarnings::class, 'index'])
         ->name('earnings.index');

    /* ---------- Search (API) ---------- */
    Route::get('/search', [DevSearch::class, 'search'])
         ->name('search');
});
