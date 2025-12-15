<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\JobVacancyController;
use App\Http\Controllers\Api\PartnerCompanyController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\ContactMessageController;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// User khusus login
Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('testimonials', [TestimonialController::class, 'store']);
    Route::post('contact-messages', [ContactMessageController::class, 'store']);

    // Admin only
    Route::middleware('admin')->group(function () {
        Route::apiResource('news', NewsController::class);
        Route::apiResource('galleries', GalleryController::class);
        Route::apiResource('partner-companies', PartnerCompanyController::class);
        Route::apiResource('job-vacancies', JobVacancyController::class);
        Route::apiResource('testimonials', TestimonialController::class)->only(['index', 'show', 'destroy']);
        Route::apiResource('contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);
    });
});

// Fallback JSON buat route yang tidak ditemukan
Route::fallback(function () {
    return response()->json([
        'message' => 'Resource not found.',
    ], 404);
});
