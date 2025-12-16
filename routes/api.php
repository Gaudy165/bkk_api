<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\JobApplicationController;
use App\Http\Controllers\Api\JobVacancyController;
use App\Http\Controllers\Api\PartnerCompanyController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\ContactMessageController;
use App\Http\Controllers\Api\MajorController;

/*
|--------------------------------------------------------------------------
| PUBLIC (tanpa login) - untuk landing page
|--------------------------------------------------------------------------
| Hanya READ-ONLY dan hanya data yang "published/active".
*/

Route::prefix('public')->group(function () {

    // Job Vacancies (Landing page)
    Route::get('job-vacancies', [JobVacancyController::class, 'publicIndex']);
    Route::get('job-vacancies/{jobVacancy}', [JobVacancyController::class, 'publicShow']);

    // submit lamaran kerja
    Route::post('job-applications', [JobApplicationController::class, 'store']);

    // (Opsional) konten publik lain
    Route::get('news', [NewsController::class, 'publicIndex']);
    Route::get('news/{slug}', [NewsController::class, 'publicShow']);

    Route::get('galleries', [GalleryController::class, 'publicIndex']);
    Route::get('partner-companies', [PartnerCompanyController::class, 'publicIndex']);

    Route::get('testimonials', [TestimonialController::class, 'publicIndex']);

    Route::get('majors', [MajorController::class, 'publicIndex']);
});


/*
|--------------------------------------------------------------------------
| AUTH (tanpa login -> login/register)
|--------------------------------------------------------------------------
*/
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| PRIVATE (wajib login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // User setelah login
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    // User submit (boleh login tapi bukan admin)
    Route::post('testimonials', [TestimonialController::class, 'store']);
    Route::post('contact-messages', [ContactMessageController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY (wajib login + role admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {
        Route::apiResource('news', NewsController::class);
        Route::apiResource('galleries', GalleryController::class);
        Route::apiResource('partner-companies', PartnerCompanyController::class);
        Route::apiResource('job-vacancies', JobVacancyController::class);

        Route::apiResource('job-applications', JobApplicationController::class)
            ->except(['store']);

        Route::apiResource('testimonials', TestimonialController::class)
            ->only(['index', 'show', 'destroy']);

        Route::apiResource('contact-messages', ContactMessageController::class)
            ->only(['index', 'show', 'destroy']);
    });
});


/*
|--------------------------------------------------------------------------
| Fallback JSON buat route yang tidak ditemukan
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->json([
        'message' => 'Resource not found.',
    ], 404);
});
