<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\HotelStaffController;
use App\Http\Controllers\RestaurantStaffController;
use App\Http\Controllers\StaffMypageContoroller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MockReservationController;
use App\Http\Controllers\TmpHotelController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');

    # Admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function() {
        Route::get('/', [AdminController::class, 'index'])->name('home');
        
    });
    
    # Staff
        # Hotel
    Route::group(['prefix' => 'hotel', 'as' => 'hotel.', 'middleware' => 'hotel'], function() {
        Route::get('/', [HotelStaffController::class, 'index'])->name('home');
        Route::get('/reservations', [HotelStaffController::class, 'reservations'])->name('reservations');
        Route::get('/mypage', [StaffMypageContoroller::class, 'index'])->name('mypage');
        Route::get('/mypage/edit', [StaffMypageContoroller::class, 'editStaffMypage'])->name('mypage.edit');
        Route::post('/mypage/store', [StaffMypageContoroller::class, 'storeHotel'])->name('mypage.store');
    });

        # Restaurant
    Route::group(['prefix' => 'restaurant', 'as' => 'restaurant.', 'middleware' => 'restaurant'], function() {
        Route::get('/', [RestaurantStaffController::class, 'index'])->name('home');
        Route::get('/reservations', [RestaurantStaffController::class, 'reservations'])->name('reservations');
        Route::get('/mypage', [StaffMypageContoroller::class, 'indexRestaurant'])->name('mypage');
        Route::get('/mypage/edit', [StaffMypageContoroller::class, 'editStaffMypagerestaurant'])->name('edit');
        Route::put('/mypage/update', [StaffMypageContoroller::class, 'updateStaffMypagerestaurant'])->name('update');
    });

    # User
    Route::group(['prefix'=>'user','as'=>'user.'],function(){
        # User Home


        # User MyPage
        Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');
        Route::get('/mypage/edit', [MyPageController::class, 'editPersonal'])->name('mypage.edit');
        Route::post('/mypage/updateProfile', [MyPageController::class, 'updatePersonal'])->name('mypage.updateProfile');
        Route::get('/mypage/edit/adress', [MyPageController::class, 'editAdress'])->name('edit.adress');
        Route::post('/mypage/edit/updateAdress', [MyPageController::class, 'updateAdress'])->name('update.adress');
        Route::get('/mypage/edit/profile', [MyPageController::class, 'editProfile'])->name('edit.profile');
        Route::post('/mypage/edit/updateProfile', [MyPageController::class, 'updateProfile'])->name('update.profile');
        Route::get('/mypage/booking', [BookingController::class, 'index'])->name('booking');
        Route::get('/mypage/favorite', [FavoriteController::class, 'index'])->name('favorite');
    
        # User Booking
        Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
        Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
    });
});

// staff page home for staff 
// hotel
Route::prefix('staff')->middleware('auth')->group(function () {
  
    
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






// フォーム表示（GET）signup-for-company
Route::get('signup-for-company', [TmpHotelController::class, 'create'])
    ->name('company.signup');



// フォーム送信（POST）は既にある想定
Route::post('/user/mypage/signup-for-company', [TmpHotelController::class, 'store'])
    ->name('user.mypage.signup-for-company.store');







// rooms の作成画面（ビュー確認用）

// User
// User_signup-for-company.blade
Route::get('userpage/mypage/signup-for-company', function () {
    return view('userpage.mypage.signup-for-company');
})->name('userpage.mypage.signup-for-company');

// User_userpage\mypage\hotel-search-result.blade.php
Route::get('userpage/mypage/hotel-search-result', function () {
    return view('userpage.mypage.hotel-search-result');
})->name('userpage.mypage.hotel-search-result');

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
