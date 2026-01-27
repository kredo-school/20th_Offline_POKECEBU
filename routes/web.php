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
    return view('auth.login');
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
    
    Route::get('/staff/reservations', [HotelStaffController::class, 'reservations'])->name('staff.reservations');


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

    Route::get('/staff/reservations/restaurant', [RestaurantStaffController::class, 'reservations']) ->name('staff.reservations.restaurant');
});

Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');
Route::get('/admin/customers', [AdminController::class, 'customers'])->name('admin.customers');
Route::get('/admin/customers/edit', [AdminController::class, 'editCustomer'])->name('customers.edit');
Route::get('/admin/customers/add', [AdminController::class, 'addCustomer'])->name('customers.add');

Route::get('/admin/hotels', [AdminController::class, 'hotels'])->name('admin.hotels');
Route::get('/admin/hotel/edit', [AdminController::class, 'editHotel'])->name('hotels.edit');
Route::get('/admin/hotel/add', [AdminController::class, 'addHotel'])->name('hotel.add');
Route::get('/admin/hotel/approval',  function () {
    return view('adminpage.hotel.pending-approval');
})->name('hotel.approval');


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

// User_userpage\mypage\hotel-serch-result.blade.php
Route::get('userpage/mypage/hotel-serch-result', function () {
    return view('userpage.mypage.hotel-serch-result');
})->name('userpage.mypage.hotel-serch-result');

// User_ 投稿関係
// User_ resources\views\userpage\mypage\post . blade . php
Route::get('userpage/posts/post-list', function () {
    $all_posts = [
        ['title' => 'テスト投稿1', 'content' => 'これはダミーの投稿です'],
        ['title' => 'テスト投稿2', 'content' => 'ビュー確認用の投稿です'],
    ];
    return view('userpage.posts.post-list', compact('all_posts'));
})->name('userpage.posts.post-list');

// 作成
// {{-- resources\views\userpage\posts\create.blade.php --}}
Route::get('userpage/posts/create', function () {
    return view('userpage.posts.create');
})->name('userpage.posts.create');

// 表示
Route::get('userpage/posts/show', function () {
    return view('userpage.posts.show');
})->name('userpage.posts.show');

// 編集
Route::get('userpage/posts/edit', function () {
    return view('userpage.posts.edit');
})->name('userpage.posts.edit');


//Staff
//Staff add-for-hotel
Route::get('staffpage/add-for-hotel', function () {
    return view('staffpage.add-for-hotel');
})->name('staffpage.add-for-hotel');

//Staff add-for-restaurant
Route::get('staffpage/add-for-restaurant', function () {
    return view('staffpage.add-for-restaurant');
})->name('staffpage.add-for-restaurant');

Route::get('admin/categories', function () {
    return view('adminpage.category.index');
})->name('adminpage.category.index');
//Staff table-type
Route::get('staffpage/table-type', function () {
    return view('staffpage.table-type');
})->name('staffpage.table-type');
//jeepney
Route::get('/jeepney', function () { return view('jeepney'); })->name('jeepney');

// MAEDA DA・YO⭐︎
// Reservation infomation detel の作成画面（view確認画面）
Route::get('/staffpage/resavation-hotel-info', function() {
    return view('staffpage.resavation-hotel-info');
})->name('staffpage.resavation-hotel-info');





Route::group(['middleware' => 'auth'], function(){

    # Admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function() {
        
    });
    
    # Staff
    Route::group(['prefix' => 'staff', 'as' => 'staff.', 'middleware' => 'staff'], function() {
        
    });

    # User　　これより下はuserが見れるところ　下にある感じで機能ごとにグループを分けてください
    # User Home


    # User MyPage


    # User Booking

});
