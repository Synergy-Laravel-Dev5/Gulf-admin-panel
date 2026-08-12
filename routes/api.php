<?php

use App\Http\Controllers\Api\VisaCountryController;
use App\Http\Controllers\Api\VisaApplicationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\VisaTypeController;
use App\Http\Controllers\Api\HajjPackageController;
use App\Http\Controllers\Api\UmrahPackageController;
use App\Http\Controllers\Api\DomesticPackageController;
use App\Http\Controllers\Api\InternationalPackageController;
use App\Http\Controllers\Api\PackageBookingController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\HotelBookingController as ApiHotelBookingController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TutorialController;
use App\Http\Controllers\Api\PageController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::get('visa-countries', [VisaCountryController::class, 'index']);
Route::get('visa-countries/{id}', [VisaCountryController::class, 'show']);
Route::get('visa-countries/{id}/visas', [VisaCountryController::class, 'visas']);

Route::get('visa-types', [VisaTypeController::class, 'index']);
Route::get('visa-types/{id}', [VisaTypeController::class, 'show']);


Route::get('hajj-packages', [HajjPackageController::class, 'index']);
Route::get('hajj-packages/{id}', [HajjPackageController::class, 'show']);

Route::get('umrah-packages', [UmrahPackageController::class, 'index']);
Route::get('umrah-packages/{id}', [UmrahPackageController::class, 'show']);

Route::get('domestic-packages', [DomesticPackageController::class, 'index']);
Route::get('domestic-packages/{id}', [DomesticPackageController::class, 'show']);

Route::get('international-packages', [InternationalPackageController::class, 'index']);
Route::get('international-packages/{id}', [InternationalPackageController::class, 'show']);

Route::get('hotels', [HotelController::class, 'index']);
Route::get('hotels/cities', [HotelController::class, 'cities']);
Route::get('hotels/{id}', [HotelController::class, 'show']);

Route::post('package-bookings', [PackageBookingController::class, 'store']);
Route::post('hotel-bookings', [ApiHotelBookingController::class, 'store']);

// Public Tutorial Routes
Route::get('tutorials', [TutorialController::class, 'index']);
Route::get('tutorials/{id}', [TutorialController::class, 'show']);

// Terms & Conditions and Privacy Policy Routes
Route::get('terms-and-conditions', [PageController::class, 'termsAndConditions']);
Route::get('privacy-policy', [PageController::class, 'privacyPolicy']);



Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/deactivate-account', [AuthController::class, 'deactivateAccount']);

    // User Profile & Document Upload Routes
    Route::get('profile', [ProfileController::class, 'getProfile']);
    Route::post('profile', [ProfileController::class, 'updateProfile']);
    Route::put('profile', [ProfileController::class, 'updateProfile']);
    Route::post('profile/upload-documents', [ProfileController::class, 'uploadDocuments']);

    Route::post('visa-countries', [VisaCountryController::class, 'store']);
    Route::put('visa-countries/{id}', [VisaCountryController::class, 'update']);
    Route::delete('visa-countries/{id}', [VisaCountryController::class, 'destroy']);

    Route::post('visa-types', [VisaTypeController::class, 'store']);
    Route::put('visa-types/{id}', [VisaTypeController::class, 'update']);
    Route::delete('visa-types/{id}', [VisaTypeController::class, 'destroy']);

    Route::get('visa-applications', [VisaApplicationController::class, 'index']);
    Route::post('visa-applications', [VisaApplicationController::class, 'store']);
    Route::get('visa-applications/{id}', [VisaApplicationController::class, 'show']);
    Route::put('visa-applications/{id}/status', [VisaApplicationController::class, 'updateStatus']);
    Route::delete('visa-applications/{id}', [VisaApplicationController::class, 'destroy']);

    Route::get('package-bookings', [PackageBookingController::class, 'index']);
    Route::get('package-bookings/{id}', [PackageBookingController::class, 'show']);

    Route::get('hotel-bookings', [ApiHotelBookingController::class, 'index']);
    Route::get('hotel-bookings/{id}', [ApiHotelBookingController::class, 'show']);

    // Admin Tutorial Routes
    Route::post('tutorials', [TutorialController::class, 'store']);
    Route::post('tutorials/{id}', [TutorialController::class, 'update']);
    Route::put('tutorials/{id}', [TutorialController::class, 'update']);
    Route::delete('tutorials/{id}', [TutorialController::class, 'destroy']);
});
