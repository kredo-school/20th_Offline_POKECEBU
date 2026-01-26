<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\HotelStaffController;
use App\Http\Controllers\RestaurantStaffController;
use App\Http\Controllers\StaffMypageContoroller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MockReservationController;
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


    Route::get('/mypage/hotel', [StaffMypageContoroller::class, 'index'])
        ->name('staff.mypage');

    Route::get('/staff/edit/hotel', [StaffMypageContoroller::class, 'editStaffMypage'])
        ->name('staff.edit');
    
    Route::get('/mypage/restaurant',[StaffMypageContoroller::class,'indexRestaurant'])
    ->name('staff.mypage.restaurant');

    Route::get('edit.restaurant',[StaffMypageContoroller::class,'editStaffMypagerestaurant'])
    ->name('staff.edit-restaurant');
    



    // restaurant
    Route::get('/restaurant', [RestaurantStaffController::class, 'index'])
        ->name('staff.homerestaurant');
});

Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');
Route::get('/admin/customers', [AdminController::class, 'customers'])->name('admin.customers');
Route::get('/admin/customers/edit', [AdminController::class, 'editCustomer'])->name('customers.edit');
Route::get('/admin/customers/add', [AdminController::class, 'addCustomer'])->name('customers.add');

Route::get('/admin/hotels', [AdminController::class, 'hotels'])->name('admin.hotels');
Route::get('/admin/hotel/edit', [AdminController::class, 'editHotel'])->name('hotels.edit');
Route::get('/admin/hotel/add', [AdminController::class, 'addHotel'])->name('hotel.add');

Route::get('/admin/restaurants', [AdminController::class, 'restaurants'])->name('admin.restaurants');
Route::get('/admin/restaurant/edit', [AdminController::class, 'editRestaurant'])->name('restaurant.edit');
Route::get('/admin/restaurant/add', [AdminController::class, 'addRestaurant'])->name('restaurant.add');

Route::get('/admin/admins', [AdminController::class, 'admins'])->name('admin.admins');
Route::get('/admin/admin/edit', [AdminController::class, 'editAdmin'])->name('admin.edit');
Route::get('/admin/admin/add', [AdminController::class, 'addAdmin'])->name('admin.add');



// カレンダー
// routes/web.php
Route::get('/mock/calendar', [MockReservationController::class, 'calendar'])->name('mock.calendar');
Route::get('/mock/day/{day}', [MockReservationController::class, 'dayStatus'])->name('mock.day');
Route::get('/mock/detail/{day}/{type}', [MockReservationController::class, 'detail'])->name('mock.detail');












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

//staff
//staffpage\add-for-restaurant.blade.php
Route::get('staffpage/add-for-restaurant', function () {
    return view('staffpage.add-for-restaurant');
})->name('staffpage.add-for-restaurant');

//resources\views\staffpage\table-type.blade.php
Route::get('staffpage/table-type', function () {
    return view('staffpage.table-type');
})->name('staffpage.table-type');
