<?php

use App\Http\Controllers\Admin\AnalysisController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\HotelStaffController;
use App\Http\Controllers\RestaurantStaffController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelReservationController;
use App\Http\Controllers\HotelRoomController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MockReservationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RestaurantTableController;
use App\Http\Controllers\TmpHotelController;

use App\Http\Controllers\RestaurantReservationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StaffAnalysisController;
use App\Http\Controllers\UserDetailController;



use App\Http\Controllers\StaffMypageController;
use App\Models\Hotel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

    # Admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('home');

        // Adomin POST
        Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
        Route::delete('/posts/{id}/deactivate', [PostsController::class, 'deactivate'])->name('posts.deactivate');
        Route::patch('/posts/{id}/activate', [PostsController::class, 'activate'])->name('posts.activate');

        # For Category
        Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
        Route::patch('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
        Route::get('/category-type', [TypeController::class, 'index'])->name('category.type-index');
        Route::post('/category-type/store', [TypeController::class, 'store'])->name('category-type.store');
        Route::delete('/category-type/delete/{id}', [TypeController::class, 'destroy'])->name('category-type.destroy');
        Route::patch('/category-type/update/{id}', [TypeController::class, 'update'])->name('category-type.update');

        ### All Users
        Route::get('/all-users', [AdminController::class, 'showAllUsers'])->name('showAllUsers');
        # For Customer
        Route::get('/all-users', [AdminController::class, 'showAllUsers'])->name('showAllUsers');
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

        # Hotel/Restaurant List
        Route::get('/showList/{name}', [AdminController::class, 'showList'])->name('showList');

        // ホテル予約
        Route::get('/hotels', [HotelController::class, 'roomInfo'])->name('hotels.index');
        Route::get('/reservation/confirmation', [HotelReservationController::class, 'confirmation'])->name('reservation.confirmation');
        Route::post('/reservation/confirm', [HotelReservationController::class, 'confirmReservation'])->name('reservation.confirm');
       Route::match(['get', 'post'], '/reservation/payment-form', [HotelReservationController::class, 'payment'])->name('reservation.payment.form');
        Route::post('/reservation/payment', [HotelReservationController::class, 'pay'])->name('reservation.pay');
            Route::get('/reservation/payment/success', [HotelReservationController::class, 'reservationSuccess'])->name('reservation.success');

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

        // 2/10ホテル承認,却下処理
        Route::get('/hotel/approval', [AdminController::class, 'hotelApproval'])->name('hotel.approval');
        Route::get('/hotel/approval/{id}', [AdminController::class, 'showPending'])->name('hotel.approval.show');
        Route::post('/hotel/approve/{id}', [AdminController::class, 'approveHotel'])->name('hotel.approve');
        Route::post('/hotels/{id}/reject', [AdminController::class, 'rejectHotel'])->name('hotel.reject');
        Route::get('/hotel/{id}/detail', [AdminController::class, 'showDetailHotel'])->name('showDetailHotel');

        // restaurant approve/reject
        Route::get('/restaurant/approval', [AdminController::class, 'approvalRestaurant'])->name('approvalRestaurant');
        Route::get('/restaurant/approval/{id}', [AdminController::class, 'showPendingRestaurant'])->name('showPendingRestaurant');
        Route::post('/restaurant/approve/{id}', [AdminController::class, 'approveRestaurant'])->name('approveRestaurant');
        Route::post('/restaurant/{id}/reject', [AdminController::class, 'rejectRestaurant'])->name('rejectRestaurant');
        Route::get('/restaurant/{id}/detail', [AdminController::class, 'showDetailRestaurant'])->name('showDetailRestaurant');

        #For Analysis
        Route::get('/analysis/hotel/{id?}', [AnalysisController::class, 'hotelAnalysis'])->name('analysis.hotel');
        Route::get('/analysis/restaurant/{id?}',[AnalysisController::class, 'restaurantAnalysis'])->name('analysis.restaurant');
    });

    # Staff
    Route::group(['prefix' => 'hotel', 'as' => 'hotel.', 'middleware' => 'hotel'], function () {
        # Hotel
        
    Route::get('/mypage/hotel', [StaffMypageController::class, 'index'])->name('mypage.hotel');
   Route::get('/mypage/hotel/edit', [StaffMypageController::class, 'editStaffMypage'])->name('staff.mypage.hotel.edit');   
    Route::post('/mypage/hotel/store', [StaffMypageController::class, 'storeHotel'])->name('mypage.hotel.store');
Route::get('/mypage/hotel/complete', [StaffMypageController::class, 'complete'])->name('mypage.hotel.complete');

        Route::get('/reservations', [HotelReservationController::class, 'hotel'])->name('reservations');
        Route::get('/reservations/{id}', [HotelReservationController::class, 'show'])->name('reservations.show');

        Route::get('/analysis/{id}',[StaffAnalysisController::class,'hotelAnalysis'])->name('analysis');

        #Hotel - Room
        Route::get('/{hotel_id}/overview', [HotelRoomController::class, 'index'])->name('overview');
        Route::post('/{hotel_id}/storeRoomType', [HotelRoomController::class, 'storeRoomType'])->name('storeRoomType');
        Route::patch('/{id}/updateRoomType', [HotelRoomController::class, 'updateRoomType'])->name('updateRoomType');
        Route::delete('/{id}/destroyRoomType', [HotelRoomController::class, 'destroyRoomType'])->name('destroyRoomType');
        Route::get('/{hotel_id}/createRoom', [HotelRoomController::class, 'createRoom'])->name('createRoom');
        Route::post('/{hotel_id}/storeRoom', [HotelRoomController::class, 'storeRoom'])->name('storeRoom');
        Route::get('/{hotel_id}/{id}/editRoom', [HotelRoomController::class, 'editRoom'])->name('editRoom');
        Route::patch('/{id}/updateRoom', [HotelRoomController::class, 'updateRoom'])->name('updateRoom');
        Route::delete('/{id}/destroyRoom', [HotelRoomController::class, 'destroyRoom'])->name('destroyRoom');
        Route::patch('/{id}/updateStatus', [HotelRoomController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}/viewRoom', [HotelRoomController::class, 'viewRoom'])->name('viewRoom');
    });

    Route::group(['prefix' => 'restaurant', 'as' => 'restaurant.', 'middleware' => 'restaurant'], function () {
        # Restaurant
        Route::get('/', [RestaurantStaffController::class, 'index'])->name('home');
        Route::get('/mypage', [StaffMypageController::class, 'indexRestaurant'])->name('mypage');
        Route::get('/mypage/edit', [StaffMypageController::class, 'editStaffMypagerestaurant'])->name('restaurant.edit');
        Route::put('/mypage/update', [StaffMypageController::class, 'updateStaffMypagerestaurant'])->name('update');

        Route::get('/reservations', [RestaurantStaffController::class, 'reservations'])->name('reservations');
        Route::get('/reservations/{id}', [RestaurantReservationController::class, 'show'])->name('reservations.show');

        route::get('/analysis/{id}',[StaffAnalysisController::class,'restaurantAnalysis'])->name('analysis');

        #Restaurant - Table
        Route::get('/{rest_id}/overview', [RestaurantTableController::class, 'index'])->name('overview');
        Route::post('/{rest_id}/storeTableType', [RestaurantTableController::class, 'storeTableType'])->name('storeTableType');
        Route::patch('/{id}/updateTableType', [RestaurantTableController::class, 'updateTableType'])->name('updateTableType');
        Route::delete('/{id}/destroyTableType', [RestaurantTableController::class, 'destroyTableType'])->name('destroyTableType');
        Route::get('/{rest_id}/createTable', [RestaurantTableController::class, 'createTable'])->name('createTable');
        Route::post('/{rest_id}/storeTable', [RestaurantTableController::class, 'storeTable'])->name('storeTable');
        Route::get('/{rest_id}/{id}/editTable', [RestaurantTableController::class, 'editTable'])->name('editTable');
        Route::patch('/{id}/updateTable', [RestaurantTableController::class, 'updateTable'])->name('updateTable');
        Route::delete('/{id}/destroyTable', [RestaurantTableController::class, 'destroyTable'])->name('destroyTable');
        Route::patch('/{id}/updateStatus', [RestaurantTableController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}/viewTable', [RestaurantTableController::class, 'viewTable'])->name('viewTable');
    });

    # User
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        # User Home
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}/destroy', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::get('/tags/{tag}', [PostController::class, 'tag'])->name('tags.show');
        route::post('/posts/{post_id}/comments', [CommentController::class, 'store'])->name('comment.store');
        route::delete('/comments/{comment_id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');

        Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
        Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

        // レビュー
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        # User MyPage
        Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');
        Route::get('/mypage/edit', [MyPageController::class, 'editPersonal'])->name('mypage.edit');
        Route::post('/mypage/updateProfile', [MyPageController::class, 'updatePersonal'])->name('mypage.updateProfile');

        Route::post('/user/mypage/delete-avatar', [MyPageController::class, 'deleteAvatar'])->name('delete.avatar');

        Route::get('/mypage/edit/adress', [MyPageController::class, 'editAdress'])->name('edit.adress');
        Route::post('/mypage/edit/updateAdress', [MyPageController::class, 'updateAdress'])->name('update.adress');
        Route::get('/mypage/edit/profile', [MyPageController::class, 'editProfile'])->name('edit.profile');
        Route::post('/mypage/edit/updateProfile', [MyPageController::class, 'updateProfile'])->name('update.profile');
        Route::get('/mypage/booking', [BookingController::class, 'index'])->name('booking');
        Route::get('/mypage/favorite', [FavoriteController::class, 'index'])->name('favorite');
        
        # Hotel searchx
        Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
        
        # User Booking
        Route::get('/hotels/{id}', [HotelController::class, 'showDetailHotel'])->name('hotels.detail');
        Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
        Route::get('/restaurants/{id}', [RestaurantController::class, 'showDetailRestaurant'])->name('restaurants.detail');
        
        # お気に入り
        Route::post('/favorite/{type}/{id}', [FavoriteController::class, 'store'])->name('favorite.store');
        Route::delete('/favorite/{type}/{id}', [FavoriteController::class, 'destroy'])->name('favorite.destroy');
    });
});


Route::get('/userhotel', function () {
    return view('userpage.booking.hotel');
})->name('user.hotel');
Route::middleware('auth')->group(function () {
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');
    Route::get('/mypage/edit', [MyPageController::class, 'editPersonal'])->name('mypage.edit');
    Route::post('/mypage/updateProfile', [MyPageController::class, 'updatePersonal'])->name('mypage.updateProfile');
    Route::get('/mypage/edit/adress', [MyPageController::class, 'editAdress'])->name('edit.adress');
    Route::post('/mypage/edit/updateAdress', [MyPageController::class, 'updateAdress'])->name('update.adress');
    Route::get('/mypage/edit/profile', [MyPageController::class, 'editProfile'])->name('edit.profile');
    Route::post('/mypage/edit/updateProfile', [MyPageController::class, 'updateProfile'])->name('update.profile');
    Route::get('mypage/booking', [BookingController::class, 'index'])->name('booking');
    Route::get('mypage/favorite', [FavoriteController::class, 'index'])->name('favorite');
});

// ホテル予約
Route::get('/hotels', [HotelController::class, 'roomInfo'])->name('hotels.index');
Route::get('reservation/confirmation', [HotelReservationController::class, 'confirmation'])
    ->name('reservation.confirmation');
Route::post('reservation/confirm', [HotelReservationController::class, 'confirmReservation'])
    ->name('reservation.confirm');
Route::match(['get', 'post'], '/reservation/payment-form', [HotelReservationController::class, 'payment'])
    ->name('reservation.payment.form');
Route::post('reservation/payment', [HotelReservationController::class, 'pay'])
    ->name('reservation.pay');
Route::get('reservation/payment/success', [HotelReservationController::class, 'reservationSuccess'])->name('reservation.success');
Route::post('reservation/payment', [HotelReservationController::class, 'pay'])->name('reservation.pay');

// ホテル予約ユーザー


Route::middleware('auth')->group(function () {
    Route::get('/mypage/user', [UserDetailController::class, 'show'])->name('mypage.show');
    Route::post('/mypage/userupdate', [UserDetailController::class, 'update'])->name('mypage.update');
});


// レストラン予約
Route::get('/restaurant/reservation', [RestaurantReservationController::class, 'showInfo'])
    ->name('restaurant.show');

Route::post('/restaurant/reserve', [RestaurantReservationController::class, 'store'])
    ->name('restaurant.reserve');



// これ

Route::prefix('staff')->middleware('auth')->group(function () {


    Route::get('/hotel', [HotelStaffController::class, 'index'])->name('staff.homehotel');
    Route::get('/staff/reservations', [HotelStaffController::class, 'reservations'])->name('staff.reservations');

    Route::get('/staff/mypage/hotel', [StaffMypageController::class, 'index'])->name('staff.mypage.hotel');
    Route::get('/staff/mypage/hotel/edit', [StaffMypageController::class, 'editStaffMypage'])->name('staff.mypage.hotel.edit');
    Route::post('/staff/mypage/hotel/store', [StaffMypageController::class, 'storeHotel'])->name('staff.mypage.hotel.store');

    Route::get('/staff/mypage/restaurant', [StaffMypageController::class, 'indexRestaurant'])->name('staff.mypage.restaurant');
    Route::get('/staff/mypage/restaurant/edit', [StaffMypageController::class, 'editStaffMypagerestaurant'])->name('staff.edit.restaurant');
    Route::post('/staff/mypage/restaurant/update', [StaffMypageController::class, 'updateStaffMypagerestaurant'])->name('staff.update.restaurant');
       Route::get('/mypage/restaurant/complete', [StaffMypageController::class, 'restaurantcomplete'])->name('restaurant.complete');

    Route::get('/restaurant', [RestaurantStaffController::class, 'index'])->name('staff.homerestaurant');
    Route::get('/staff/reservations/restaurant', [RestaurantStaffController::class, 'reservations'])->name('staff.reservations.restaurant');



    // restaurant
    Route::get('/restaurant', [RestaurantStaffController::class, 'index'])
        ->name('staff.homerestaurant');
});
Route::get('/admin/customers', [AdminController::class, 'customers'])->name('admin.customers');
Route::get('/admin/customers/edit', [AdminController::class, 'editCustomer'])->name('customers.edit');
Route::get('/admin/customers/add', [AdminController::class, 'addCustomer'])->name('customers.add');


Route::get('/staff/reservations/restaurant', [RestaurantStaffController::class, 'reservations'])->name('staff.reservations.restaurant');


Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');



Route::get('/admin/customer', [AdminController::class, 'customer'])->name('admin.customer');

// カスタマー
Route::get('/admin/customer/add', [AdminController::class, 'addCustomer'])->name('admin.customer.add');
Route::post('/admin/customer/add', [AdminController::class, 'storeCustomer'])->name('admin.customers.store');

// Uカスタマー
Route::get('/admin/customer/edit/{id}', [AdminController::class, 'editCustomer'])->name('admin.customer.edit');
Route::put('/admin/customer/update/{id}', [AdminController::class, 'updateCustomer'])->name('admin.customer.update');

// 
Route::delete('/admin/customer/delete/{id}', [AdminController::class, 'deleteCustomer'])->name('admin.customer.delete');
// カスタマー



// ホテル一覧
Route::get('/admin/hotels', [AdminController::class, 'hotels'])->name('admin.hotels');

// ホテル追加
// ホテル追加画面（GET）
Route::get('/admin/hotel/add', [AdminController::class, 'addHotel'])->name('admin.hotel.add');

// ホテル保存処理（POST）
Route::post('/admin/hotel/add', [AdminController::class, 'storeHotel'])->name('admin.hotel.store');

// ホテル編集
Route::get('/admin/hotel/edit/{id}', [AdminController::class, 'editHotel'])->name('admin.hotel.edit');
Route::put('/admin/hotel/update/{id}', [AdminController::class, 'updateHotel'])->name('admin.hotel.update');

// ホテル削除
Route::delete('/admin/hotel/delete/{id}', [AdminController::class, 'deleteHotel'])->name('admin.hotel.delete');





// Route::get('/admin/hotel/approval',  function () {
//     return view('adminpage.hotel.pending-approval');
// })->name('hotel.approval');
Route::get('/admin/hotels', [AdminController::class, 'hotels'])->name('admin.hotels');
Route::get('/admin/hotel/edit', [AdminController::class, 'editHotel'])->name('hotels.edit');
Route::get('/admin/hotel/add', [AdminController::class, 'addHotel'])->name('hotel.add');








// レストラン一覧
Route::get('/admin/restaurants', [AdminController::class, 'restaurants'])->name('admin.restaurants');

// レストラン追加
Route::get('/admin/restaurant/add', [AdminController::class, 'addRestaurant'])->name('restaurant.add');
Route::post('/admin/restaurant/add', [AdminController::class, 'storeRestaurant'])->name('restaurant.store');

// レストラン編集
Route::get('/admin/restaurant/edit/{id}', [AdminController::class, 'editRestaurant'])->name('restaurant.edit');
Route::put('/admin/restaurant/update/{id}', [AdminController::class, 'updateRestaurant'])->name('restaurant.update');

// レストラン削除
Route::delete('/admin/restaurant/delete/{id}', [AdminController::class, 'deleteRestaurant'])->name('restaurant.delete');






// Admin 一覧
Route::get('/admin/admins', [AdminController::class, 'admins'])
    ->name('admin.admins');

// Admin 追加
Route::get('/admin/admin/add', [AdminController::class, 'addAdmin'])
    ->name('admin.admin.add');
Route::post('/admin/admin/add', [AdminController::class, 'storeAdmin'])
    ->name('admin.admin.store');

// Admin 編集
Route::get('/admin/admin/edit/{id}', [AdminController::class, 'editAdmin'])
    ->name('admin.admin.edit');
Route::put('/admin/admin/update/{id}', [AdminController::class, 'updateAdmin'])
    ->name('admin.admin.update');

// Admin 削除
Route::delete('/admin/admin/delete/{id}', [AdminController::class, 'deleteAdmin'])
    ->name('admin.admin.delete');




// カレンダー
// routes/web.php
Route::get('/mock/calendar', [MockReservationController::class, 'calendar'])->name('mock.calendar');
Route::get('/mock/day/{day}', [MockReservationController::class, 'dayStatus'])->name('mock.day');
Route::get('/mock/detail/{day}/{type}', [MockReservationController::class, 'detail'])->name('mock.detail');






// ログイン不要ページ　
// 　ホテル・レストラン登録
// 　フォーム表示
Route::get('signup-for-company', [TmpHotelController::class, 'create'])
    ->name('company.signup');
// 　フォーム送信
Route::post('/user/mypage/signup-for-company', [TmpHotelController::class, 'store'])
    ->name('user.mypage.signup-for-company.store');
// 　ホテル・レストランサーチ
Route::get('/hotels/search', [App\Http\Controllers\HotelController::class, 'index'])->name('hotels.search');
   










// rooms の作成画面（ビュー確認用）

// User
// User_signup-for-company.blade
// Route::get('userpage/mypage/signup-for-company', function () {
//     return view('userpage.mypage.signup-for-company');
// })->name('userpage.mypage.signup-for-company');

// User_userpage\mypage\hotel-serch-result.blade.php
// Route::get('userpage/mypage/hotel-serch-result', function () {
//     return view('userpage.mypage.hotel-serch-result');
// })->name('userpage.mypage.hotel-serch-result');




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
Route::get('/jeepney', function () {
    return view('jeepney');
})->name('jeepney');
Route::get('/admin/analysis/hotel', [AnalysisController::class, 'hotelAnalysis'])->name('admin.analysis.hotel');
Route::get('/admin/analysis/restaurant', [AnalysisController::class, 'restaurantAnalysis'])->name('admin.analysis.restaurant');









// // 他の全てのグループ（Route::group(['middleware' => 'auth']など）の外に書く　なんか無理やったやつ
// Route::middleware(['auth'])->group(function () {

//     Route::prefix('hotel')->as('hotel.')->group(function () {
//         // 完了画面
//         Route::get('/mypage/hotel/complete', [StaffMypageController::class, 'complete'])
//             ->name('mypage.hotel.complete');
            
//         // 保存処理
//         Route::post('/mypage/hotel/store', [StaffMypageController::class, 'storeHotel'])
//             ->name('mypage.hotel.store');
//     });

// });
// web.php の一番最後に追記
// --- routes/web.php の一番最後に追記 ---

// adminの中に入ってしまっている「reservation.payment.form」を
// 「adminなしのURL」として完全に新しく定義し直します
