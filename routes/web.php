<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// rooms の作成画面（ビュー確認用）

// User
// User_Sign up for Company
Route::get('User page/SignUpforCompany', function () {
    return view('User page.SignUpforCompany');
})->name('User page.SignUpforCompany');

// User_HotelSerchResult.blade.php
Route::get('User page/HotelSerchResult', function () {
    return view('User page.HotelSerchResult');
})->name('User page.HotelSerchResult');