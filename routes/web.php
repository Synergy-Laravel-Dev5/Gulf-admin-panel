<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisaApplicationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HajjPackageController;
use App\Http\Controllers\UmrahPackageController;
use App\Http\Controllers\DomesticPackageController;
use App\Http\Controllers\InternationalPackageController;
use App\Http\Controllers\PackageBookingController;
use App\Http\Controllers\VisaCountryController;
use App\Http\Controllers\MealTypeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HotelBookingController;
use App\Http\Controllers\TransportationRouteController;
use Illuminate\Support\Facades\Mail;



Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/', function () {
        return redirect()->route('login');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::prefix('admin')->group(function () {

        Route::controller(UserController::class)
            ->prefix('user')
            ->group(function () {
                Route::get('/', 'index')->name('user.index');
                Route::get('/create', 'create')->name('user.create');
                Route::post('/store', 'store')->name('user.store');
                Route::get('/show/{id}', 'show')->name('user.show');
                Route::get('/edit/{id}', 'edit')->name('user.edit');

                Route::put('/update/{id}', 'update')->name('user.update');
                Route::delete('/delete/{id}', 'destroy')->name('user.delete');
                Route::get('/trash', 'trash')->name('user.trash');
                Route::get('/restore/{id}', 'restore')->name('user.restore');
            });


        Route::controller(VisaApplicationController::class)->prefix('visa-application')->group(function () {
            Route::get('/', 'index')->name('visa-application.index');
            Route::get('/show/{id}', 'show')->name('visa-application.show');
            Route::get('/edit/{id}', 'edit')->name('visa-application.edit');
            Route::delete('/delete/{id}', 'destroy')->name('visa-application.delete');
            Route::get('/trash', 'trash')->name('visa-application.trash');
        });


        Route::controller(HajjPackageController::class)->prefix('hajj-package')->group(function () {
            Route::get('/', 'index')->name('hajj-package.index');
            Route::get('/create', 'create')->name('hajj-package.create');
            Route::post('/store', 'store')->name('hajj-package.store');
            Route::get('/edit/{id}', 'edit')->name('hajj-package.edit');
            Route::put('/update/{id}', 'update')->name('hajj-package.update');
            Route::delete('/delete/{id}', 'destroy')->name('hajj-package.delete');
            Route::get('/trash', 'trash')->name('hajj-package.trash');
            Route::get('/restore/{id}', 'restore')->name('hajj-package.restore');
        });

        Route::controller(UmrahPackageController::class)->prefix('umrah-package')->group(function () {
            Route::get('/', 'index')->name('umrah-package.index');
            Route::get('/create', 'create')->name('umrah-package.create');
            Route::post('/store', 'store')->name('umrah-package.store');
            Route::get('/edit/{id}', 'edit')->name('umrah-package.edit');
            Route::put('/update/{id}', 'update')->name('umrah-package.update');
            Route::delete('/delete/{id}', 'destroy')->name('umrah-package.delete');
            Route::get('/trash', 'trash')->name('umrah-package.trash');
            Route::get('/restore/{id}', 'restore')->name('umrah-package.restore');
        });

        Route::controller(DomesticPackageController::class)->prefix('domestic-package')->group(function () {
            Route::get('/', 'index')->name('domestic-package.index');
            Route::get('/create', 'create')->name('domestic-package.create');
            Route::post('/store', 'store')->name('domestic-package.store');
            Route::get('/edit/{id}', 'edit')->name('domestic-package.edit');
            Route::put('/update/{id}', 'update')->name('domestic-package.update');
            Route::delete('/delete/{id}', 'destroy')->name('domestic-package.delete');
            Route::get('/trash', 'trash')->name('domestic-package.trash');
            Route::get('/restore/{id}', 'restore')->name('domestic-package.restore');
        });

        Route::controller(InternationalPackageController::class)->prefix('international-package')->group(function () {
            Route::get('/', 'index')->name('international-package.index');
            Route::get('/create', 'create')->name('international-package.create');
            Route::post('/store', 'store')->name('international-package.store');
            Route::get('/edit/{id}', 'edit')->name('international-package.edit');
            Route::put('/update/{id}', 'update')->name('international-package.update');
            Route::delete('/delete/{id}', 'destroy')->name('international-package.delete');
            Route::get('/trash', 'trash')->name('international-package.trash');
            Route::get('/restore/{id}', 'restore')->name('international-package.restore');
        });


        Route::controller(PackageBookingController::class)->prefix('package-booking')->group(function () {
            Route::get('/', 'index')->name('package-booking.index');
            Route::get('/show/{id}', 'show')->name('package-booking.show');
            Route::put('/status/{id}', 'updateStatus')->name('package-booking.status');
            Route::delete('/delete/{id}', 'destroy')->name('package-booking.delete');
        });

        Route::controller(VisaCountryController::class)
            ->prefix('visa-country')
            ->group(function () {
                Route::get('/', 'index')->name('visa-country.index');
                Route::get('/create', 'create')->name('visa-country.create');
                Route::post('/store', 'store')->name('visa-country.store');
                Route::get('/edit/{id}', 'edit')->name('visa-country.edit');
                Route::put('/update/{id}', 'update')->name('visa-country.update');
                Route::delete('/delete/{id}', 'destroy')->name('visa-country.delete');
                Route::get('/trash', 'trash')->name('visa-country.trash');
                Route::get('/restore/{id}', 'restore')->name('visa-country.restore');
            });

        Route::controller(\App\Http\Controllers\HotelController::class)
            ->prefix('hotel')
            ->group(function () {
                Route::get('/', 'index')->name('hotel.index');
                Route::get('/create', 'create')->name('hotel.create');
                Route::post('/store', 'store')->name('hotel.store');
                Route::get('/edit/{id}', 'edit')->name('hotel.edit');
                Route::put('/update/{id}', 'update')->name('hotel.update');
                Route::delete('/delete/{id}', 'destroy')->name('hotel.delete');
            });

        Route::controller(MealTypeController::class)
            ->prefix('meal-type')
            ->group(function () {
                Route::get('/', 'index')->name('meal-type.index');
                Route::get('/create', 'create')->name('meal-type.create');
                Route::post('/store', 'store')->name('meal-type.store');
                Route::get('/edit/{id}', 'edit')->name('meal-type.edit');
                Route::put('/update/{id}', 'update')->name('meal-type.update');
                Route::delete('/delete/{id}', 'destroy')->name('meal-type.delete');
                Route::get('/trash', 'trash')->name('meal-type.trash');
                Route::get('/restore/{id}', 'restore')->name('meal-type.restore');
            });

        Route::controller(CityController::class)
            ->prefix('city')
            ->group(function () {
                Route::get('/', 'index')->name('city.index');
                Route::get('/create', 'create')->name('city.create');
                Route::post('/store', 'store')->name('city.store');
                Route::get('/edit/{id}', 'edit')->name('city.edit');
                Route::put('/update/{id}', 'update')->name('city.update');
                Route::delete('/delete/{id}', 'destroy')->name('city.delete');
                Route::get('/trash', 'trash')->name('city.trash');
                Route::get('/restore/{id}', 'restore')->name('city.restore');
            });

        Route::controller(HotelBookingController::class)
            ->prefix('hotel-booking')
            ->group(function () {
                Route::get('/', 'index')->name('hotel-booking.index');
                Route::get('/show/{id}', 'show')->name('hotel-booking.show');
                Route::put('/update-status/{id}', 'updateStatus')->name('hotel-booking.update-status');
                Route::delete('/delete/{id}', 'destroy')->name('hotel-booking.delete');
            });

        Route::controller(TransportationRouteController::class)
            ->prefix('transportation-route')
            ->group(function () {
                Route::get('/', 'index')->name('transportation-route.index');
                Route::get('/create', 'create')->name('transportation-route.create');
                Route::post('/store', 'store')->name('transportation-route.store');
                Route::get('/edit/{id}', 'edit')->name('transportation-route.edit');
                Route::put('/update/{id}', 'update')->name('transportation-route.update');
                Route::delete('/delete/{id}', 'destroy')->name('transportation-route.delete');
                Route::get('/trash', 'trash')->name('transportation-route.trash');
                Route::get('/restore/{id}', 'restore')->name('transportation-route.restore');
            });

        Route::controller(\App\Http\Controllers\TutorialController::class)
            ->prefix('tutorial')
            ->group(function () {
                Route::get('/', 'index')->name('tutorial.index');
                Route::get('/create', 'create')->name('tutorial.create');
                Route::post('/store', 'store')->name('tutorial.store');
                Route::get('/edit/{id}', 'edit')->name('tutorial.edit');
                Route::put('/update/{id}', 'update')->name('tutorial.update');
                Route::delete('/delete/{id}', 'destroy')->name('tutorial.delete');
                Route::get('/trash', 'trash')->name('tutorial.trash');
                Route::get('/restore/{id}', 'restore')->name('tutorial.restore');
            });
    });
});

