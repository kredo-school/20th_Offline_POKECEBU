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
// User_Sign up for Company
Route::get('userpage/mypage/SignUpforCompany', function () {
    return view('userpage.mypage.SignUpforCompany');
})->name('userpage.mypage.SignUpforCompany');

// User_HotelSerchResult.blade.php
Route::get('userpage/mypage/HotelSerchResult', function () {
    return view('userpage.mypage.HotelSerchResult');
})->name('userpage.mypage.HotelSerchResult');

//Staff addforhotel
Route::get('addforhotel', function () {
    return view('addforhotel');
})->name('addforhotel');