<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\HotelStaffController;
use App\Http\Controllers\RestaurantStaffController;
use App\Http\Controllers\AdminController;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings');
    Route::get('/favorites', [MyPageController::class, 'favorite'])->name('favorites');
    Route::get('/mypage/edit', [MyPageController::class, 'editPersonal'])->name('mypage.edit');
    Route::get('/mypage/editadress', [MyPageController::class, 'editAddress'])->name('mypage.editadress');
    Route::get('/mypage/editprofile', [MyPageController::class, 'editProfile'])->name('mypage.editprofile');
});

// booking page
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/restaurants', [RestaurantController::class, 'index']);

// staff page home for staff 
// hotel
Route::prefix('staff')->middleware('auth')->group(function () {
    Route::get('/hotel', [HotelStaffController::class, 'index'])
        ->name('staff.homehotel');

    // restaurant
    Route::get('/restaurant', [RestaurantStaffController::class, 'index'])
        ->name('staff.homerestaurant');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.home');
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/hotels', [AdminController::class, 'hotels'])->name('admin.hotels');
    Route::get('/restaurants', [AdminController::class, 'restaurants'])->name('admin.restaurants');
    Route::get('/admins', [AdminController::class, 'admins'])->name('admin.admins');
});





// keisuke 
// rooms の作成画面（ビュー確認用）

// User
// User_signup-for-company.blade
Route::get('userpage/mypage/signup-for-company', function () {
    return view('userpage.mypage.signup-for-company');
})->name('userpage.mypage.signup-for-company');

// User_HotelSerchResult.blade.php 
Route::get('userpage/mypage/HotelSerchResult', function () {
    return view('userpage.mypage.HotelSerchResult');
})->name('userpage.mypage.HotelSerchResult');

//Staff addforhotel
Route::get('add-for-hotel', function () {
    return view('add-for-hotel');
})->name('add-for-hotel');
