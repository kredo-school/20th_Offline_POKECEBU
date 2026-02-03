<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\HotelStaffController;
use App\Http\Controllers\RestaurantStaffController;
use App\Http\Controllers\StaffMypageContoroller;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelReservationController;
use App\Http\Controllers\MockReservationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

    # Admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function() {
        Route::get('/', [AdminController::class, 'index'])->name('home');
        # For Category
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index'); 
        Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

        # For Customer
        Route::get('/customer', [AdminController::class, 'customer'])->name('customer');
        Route::get('/customer/add', [AdminController::class, 'addCustomer'])->name('customer.add');
        Route::post('/customer/add', [AdminController::class, 'storeCustomer'])->name('customers.store');
        Route::get('/customer/edit/{id}', [AdminController::class, 'editCustomer'])->name('customer.edit');
        Route::put('/customer/update/{id}', [AdminController::class, 'updateCustomer'])->name('customer.update');
        Route::delete('/customer/delete/{id}', [AdminController::class, 'deleteCustomer'])->name('customer.delete');
        # For Hotel
        Route::get('/hotels', [AdminController::class, 'hotels'])->name('hotels');
        Route::get('/hotel/add', [AdminController::class, 'addHotel'])->name('hotel.add');
        Route::post('/hotel/add', [AdminController::class, 'storeHotel'])->name('hotel.store');
        Route::get('/hotel/edit/{id}', [AdminController::class, 'editHotel'])->name('hotel.edit');
        Route::put('/hotel/update/{id}', [AdminController::class, 'updateHotel'])->name('hotel.update');
        Route::delete('/hotel/delete/{id}', [AdminController::class, 'deleteHotel'])->name('hotel.delete');
        # For Restaurant
        Route::get('/restaurants', [AdminController::class, 'restaurants'])->name('restaurants');
        Route::get('/restaurant/add', [AdminController::class, 'addRestaurant'])->name('restaurant.add');
        Route::post('/restaurant/add', [AdminController::class, 'storeRestaurant'])->name('restaurant.store');
        Route::get('/restaurant/edit/{id}', [AdminController::class, 'editRestaurant'])->name('restaurant.edit');
        Route::put('/restaurant/update/{id}', [AdminController::class, 'updateRestaurant'])->name('restaurant.update');
        Route::delete('/restaurant/delete/{id}', [AdminController::class, 'deleteRestaurant'])->name('restaurant.delete');
        # For Admin
        Route::get('/admins', [AdminController::class, 'admins'])->name('admins');
        Route::get('/admin/add', [AdminController::class, 'addAdmin'])->name('admin.add');
        Route::post('/admin/add', [AdminController::class, 'storeAdmin'])->name('admin.store');
        Route::get('/admin/edit/{id}', [AdminController::class, 'editAdmin'])->name('admin.edit');
        Route::put('/admin/update/{id}', [AdminController::class, 'updateAdmin'])->name('admin.update');
        Route::delete('/admin/delete/{id}', [AdminController::class, 'deleteAdmin'])->name('admin.delete');
        
        # FAQ    
        Route::get('/faq/list', [FaqController::class, 'displayList'])->name('faq.displayList');
        Route::post('/faq/store', [FaqController::class, 'store'])->name('faq.store');
        Route::patch('/faq/{id}/update', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/faq/{id}/destroy', [FaqController::class, 'destroy'])->name('faq.destroy');
        Route::delete('/faq/{id}/hidden', [FaqController::class, 'hidden'])->name('faq.hidden');
        Route::patch('/faq/{id}/visible', [FaqController::class, 'visible'])->name('faq.visible');
        Route::post('/faq/storeCategory', [FaqController::class, 'storeCategory'])->name('faq.storeCategory');
    });
        
    # Staff
    Route::group(['prefix' => 'hotel', 'as' => 'hotel.', 'middleware' => 'hotel'], function() {
            # Hotel
            Route::get('/', [HotelStaffController::class, 'index'])->name('home');
            Route::get('/mypage', [StaffMypageContoroller::class, 'index'])->name('mypage');
            Route::get('/mypage/edit', [StaffMypageContoroller::class, 'editStaffMypage'])->name('mypage.edit');
            Route::post('/mypage/store', [StaffMypageContoroller::class, 'storeHotel'])->name('mypage.store');
            
            Route::get('/reservations', [HotelReservationController::class, 'hotel'])->name('reservations');
            // Route::get('/reservations/{id}', [HotelReservationController::class, 'show'])->name('reservations.show');
    });

    Route::group(['prefix' => 'restaurant', 'as' => 'restaurant.', 'middleware' => 'restaurant'], function() {
        # Restaurant
        Route::get('/', [RestaurantStaffController::class, 'index'])->name('home');
        Route::get('/mypage', [StaffMypageContoroller::class, 'indexRestaurant'])->name('mypage');
        Route::get('/mypage/edit', [StaffMypageContoroller::class, 'editStaffMypagerestaurant'])->name('edit');
        Route::put('/mypage/update', [StaffMypageContoroller::class, 'updateStaffMypagerestaurant'])->name('update');
        
        Route::get('/reservations', [RestaurantStaffController::class, 'reservations'])->name('reservations');
        // Route::get('/reservations/{id}', [RestaurantReservationController::class, 'show'])->name('reservations.show');

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
        Route::get('/hotels/{id}', [HotelController::class, 'showDetailHotel'])->name('hotels.detail');
        Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
    });
});


Route::get('/userhotel', function(){
    return view('userpage.booking.hotel');
})->name('user.hotel');

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

//Staff table-type
Route::get('staffpage/table-type', function () {
    return view('staffpage.table-type');
})->name('staffpage.table-type');
//jeepney
Route::get('/jeepney', function () { return view('jeepney'); })->name('jeepney');

// MAEDA DA・YO⭐︎
// Reservation infomation detel の作成画面（view確認画面）
Route::get('/staffpage/reservations/hotel-detail', function() {
return view('staffpage.reservations.hotel-detail');
})->name('staffpage.reservation/hotel-detail');

Route::get('/staffpage/reservations/restaurant-detail', function() {
    return view('staffpage.reservations.restaurant-detail');
})->name('staffpage.reservations.restaurant-detail');

