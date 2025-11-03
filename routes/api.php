<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Developer\ProjectController;
use App\Http\Controllers\Developer\OfferController;
use App\Http\Controllers\Developer\AgreementController;
use App\Http\Controllers\Developer\EarningsController;

Route::prefix('developer')->group(function () {
    Route::get('projects', [ProjectController::class, 'index']);
    Route::get('projects/{id}', [ProjectController::class, 'show']);
    Route::post('projects', [ProjectController::class, 'store']);

    Route::get('offers', [OfferController::class, 'index']);
    Route::post('offers', [OfferController::class, 'store']);

    Route::get('agreements', [AgreementController::class, 'index']);
    Route::post('agreements/{id}/sign', [AgreementController::class, 'sign']);

    Route::get('earnings', [EarningsController::class, 'index']);
    
});

// 🔍 Advanced Search untuk Developer
use App\Http\Controllers\Developer\SearchController as DeveloperSearchController;

Route::prefix('developer')->middleware('auth:sanctum')->group(function () {
    Route::get('search', [DeveloperSearchController::class, 'search']);
});

// 🔍 Advanced Search untuk Customer

use App\Http\Controllers\Customer\SearchController as CustomerSearchController;
Route::prefix('customer')->middleware('auth:sanctum')->group(function () {
    Route::get('search', [CustomerSearchController::class, 'search']);
});