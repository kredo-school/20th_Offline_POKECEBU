<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RestaurantController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings');
    Route::get('/favorites', function () {
        return view('userpage.mypage.favorite');
    })->name('favorites');
    Route::get('/mypage/edit', function () {
        return view('userpage.mypage.editpersonal');
    })->name('mypage.edit');
    Route::get('/mypage/editadress', function () {
        return view('userpage.mypage.editadress');
    })->name('mypage.editadress');
    Route::get('/mypage/editprofile', function () {
        return view('userpage.mypage.editprofile');
    })->name('mypage.editprofile');
});

Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');


Route::get('/restaurants', [RestaurantController::class, 'index']);



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