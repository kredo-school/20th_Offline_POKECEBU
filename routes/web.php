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
use App\Http\Controllers\HotelRoomController;
use App\Http\Controllers\MockReservationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RestaurantTableController;
use App\Http\Controllers\TmpHotelController;
use App\Http\Controllers\UserDetailController;
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

        // ホテル予約
        Route::get('/hotels', [HotelController::class, 'roomInfo'])->name('hotels.index');
        Route::get('reservation/confirmation', [HotelReservationController::class, 'confirmation'])->name('reservation.confirmation');
        Route::post('reservation/confirm', [HotelReservationController::class, 'confirmReservation'])->name('reservation.confirm');
        Route::post('reservation/payment-form', [HotelReservationController::class, 'payment'])->name('reservation.payment.form');
        Route::post('reservation/payment', [HotelReservationController::class, 'pay'])->name('reservation.pay');
        Route::get('reservation/payment/success',[HotelReservationController::class,'reservationSuccess'])->name('reservation.success');
        Route::get('reservation/payment', function() {return view('userpage.booking.hotel.payment');})->name('reservation.payment.form');
        Route::post('reservation/payment', [HotelReservationController::class, 'pay'])->name('reservation.pay');

        // ホテル予約ユーザー詳細
        Route::get('/mypage/user', [UserDetailController::class, 'show'])->name('mypage.show');
        Route::post('/mypage/userupdate', [UserDetailController::class, 'update'])->name('mypage.update');
        
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

        #Hotel - Room
        Route::get('/{hotel_id}/overview', [HotelRoomController::class, 'index'])->name('overview');
        Route::post('/{hotel_id}/storeRoomType', [HotelRoomController::class, 'storeRoomType'])->name('storeRoomType');
        Route::patch('/{id}/updateRoomType', [HotelRoomController::class, 'updateRoomType'])->name('updateRoomType');
        Route::delete('/{id}/destroyRoomType', [HotelRoomController::class, 'destroyRoomType'])->name('destroyRoomType');
        Route::post('/{hotel_id}/storeRoom', [HotelRoomController::class, 'storeRoom'])->name('storeRoom');
        Route::patch('/{id}/updateRoom', [HotelRoomController::class, 'updateRoom'])->name('updateRoom');
        Route::delete('/{id}/destroyRoom', [HotelRoomController::class, 'destroyRoom'])->name('destroyRoom');
        Route::patch('/{id}/updateStatus', [HotelRoomController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::group(['prefix' => 'restaurant', 'as' => 'restaurant.', 'middleware' => 'restaurant'], function() {
        # Restaurant
        Route::get('/', [RestaurantStaffController::class, 'index'])->name('home');
        Route::get('/mypage', [StaffMypageContoroller::class, 'indexRestaurant'])->name('mypage');
        Route::get('/mypage/edit', [StaffMypageContoroller::class, 'editStaffMypagerestaurant'])->name('edit');
        Route::put('/mypage/update', [StaffMypageContoroller::class, 'updateStaffMypagerestaurant'])->name('update');
        
        Route::get('/reservations', [RestaurantStaffController::class, 'reservations'])->name('reservations');
        // Route::get('/reservations/{id}', [RestaurantReservationController::class, 'show'])->name('reservations.show');

        #Restaurant - Table
        Route::get('/{rest_id}/overview', [RestaurantTableController::class, 'index'])->name('overview');
        Route::post('/{rest_id}/storeTableType', [RestaurantTableController::class, 'storeTableType'])->name('storeTableType');
        Route::patch('/{id}/updateTableType', [RestaurantTableController::class, 'updateTableType'])->name('updateTableType');
        Route::delete('/{id}/destroyTableType', [RestaurantTableController::class, 'destroyTableType'])->name('destroyTableType');
        Route::post('/{rest_id}/storeTable', [RestaurantTableController::class, 'storeTable'])->name('storeTable');
        Route::patch('/{id}/updateTable', [RestaurantTableController::class, 'updateTable'])->name('updateTable');
        Route::delete('/{id}/destroyTable', [RestaurantTableController::class, 'destroyTable'])->name('destroyTable');
        Route::patch('/{id}/updateStatus', [RestaurantTableController::class, 'updateStatus'])->name('updateStatus');
    });

    # User
    Route::group(['prefix'=>'user','as'=>'user.'],function(){
        # User Home
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


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
        Route::get('/restaurants/{id}', [RestaurantController::class, 'showDetailRestaurant'])->name('restaurants.detail');
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

// User_userpage\mypage\hotel-serch-result.blade.php
Route::get('userpage/mypage/hotel-serch-result', function () {
    return view('userpage.mypage.hotel-serch-result');
})->name('userpage.mypage.hotel-serch-result');




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