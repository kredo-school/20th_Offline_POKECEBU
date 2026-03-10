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
use App\Http\Controllers\JeepneyController;
use App\Http\Controllers\DailyFortuneController;

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

    #################### Admin ####################
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        Route::get('/adminhome', [AdminController::class, 'index'])->name('home');

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
        Route::get('/category-post', [PostsController::class, 'index'])->name('category.post-index');  
        Route::delete('/category-post/deactive/{id}', [PostsController::class, 'deactivate'])->name('category-post.deactivate');
        Route::patch('/category-post/activate/{id}', [PostsController::class, 'activate'])->name('category-post.activate');

        ### All Users
        Route::get('/all-users', [AdminController::class, 'showAllUsers'])->name('showAllUsers');
        # All Users - Customer
        Route::get('/customers', [AdminController::class, 'customers'])->name('customers');
        Route::get('/customer/add', [AdminController::class, 'addCustomer'])->name('customer.add');
        Route::post('/customer/add', [AdminController::class, 'storeCustomer'])->name('customers.store');
        Route::get('/customer/edit/{id}', [AdminController::class, 'editCustomer'])->name('customer.edit');
        Route::put('/customer/update/{id}', [AdminController::class, 'updateCustomer'])->name('customer.update');
        Route::delete('/customer/delete/{id}', [AdminController::class, 'deleteCustomer'])->name('customer.delete');

        # All Users - Hotel
        Route::get('/hotels', [AdminController::class, 'hotels'])->name('hotels');
        Route::get('/hotel/add', [AdminController::class, 'addHotel'])->name('hotel.add');
        Route::post('/hotel/add', [AdminController::class, 'storeHotel'])->name('hotel.store');
        Route::get('/hotel/edit/{id}', [AdminController::class, 'editHotel'])->name('hotel.edit');
        Route::put('/hotel/update/{id}', [AdminController::class, 'updateHotel'])->name('hotel.update');
        Route::delete('/hotel/delete/{id}', [AdminController::class, 'deleteHotel'])->name('hotel.delete');

        # All Users - Restaurant
        Route::get('/restaurants', [AdminController::class, 'restaurants'])->name('restaurants');
        Route::get('/restaurant/add', [AdminController::class, 'addRestaurant'])->name('restaurant.add');
        Route::post('/restaurant/add', [AdminController::class, 'storeRestaurant'])->name('restaurant.store');
        Route::get('/admin/restaurant/edit/{id}', [AdminController::class, 'editRestaurant'])->name('restaurant.edit');
        Route::put('/admin/restaurant/update/{id}', [AdminController::class, 'updateRestaurant'])->name('restaurant.update');
        Route::delete('/admin/restaurant/delete/{id}', [AdminController::class, 'deleteRestaurant'])->name('restaurant.delete');
        // カレンダー
        # All Users- Admin
        Route::get('/admins', [AdminController::class, 'admins'])->name('admins');
        Route::get('/admin/add', [AdminController::class, 'addAdmin'])->name('admin.add');
        Route::post('/admin/add', [AdminController::class, 'storeAdmin'])->name('admin.store');
        Route::get('/admin/edit/{id}', [AdminController::class, 'editAdmin'])->name('admin.edit');
        Route::put('/admin/update/{id}', [AdminController::class, 'updateAdmin'])->name('admin.update');
        Route::delete('/admin/delete/{id}', [AdminController::class, 'deleteAdmin'])->name('admin.delete');

        # Hotel/Restaurant List
        Route::get('/showList/{name}', [AdminController::class, 'showList'])->name('showList');

        // ホテル予約
        Route::get('/hotels/reservation', [HotelController::class, 'roomInfo'])->name('hotels.index');
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
        Route::get('/analysis/user',[AnalysisController::class, 'userAnalysis'])->name('analysis.user');
    });

    #################### Hotel ####################
    Route::group(['prefix' => 'hotel', 'as' => 'hotel.', 'middleware' => 'hotel'], function () {
        Route::get('/hotelhome', [StaffAnalysisController::class,'hotelAnalysis'])->name('home');
        
        Route::get('/mypage/hotel', [StaffMypageController::class, 'index'])->name('mypage.hotel');
        Route::get('/mypage/hotel/edit', [StaffMypageController::class, 'editStaffMypage'])->name('staff.mypage.hotel.edit');   
        Route::post('/mypage/hotel/store', [StaffMypageController::class, 'storeHotel'])->name('mypage.hotel.store');
        Route::get('/mypage/hotel/complete', [StaffMypageController::class, 'complete'])->name('mypage.hotel.complete');

        #Hotel - Room overview
        Route::get('/roomOverview', [HotelRoomController::class, 'roomOverview'])->name('roomOverview');
        Route::post('/storeRoomType', [HotelRoomController::class, 'storeRoomType'])->name('storeRoomType');
        Route::patch('/{id}/updateRoomType', [HotelRoomController::class, 'updateRoomType'])->name('updateRoomType');
        Route::delete('/{id}/destroyRoomType', [HotelRoomController::class, 'destroyRoomType'])->name('destroyRoomType');
        Route::get('/createRoom', [HotelRoomController::class, 'createRoom'])->name('createRoom');
        Route::post('/storeRoom', [HotelRoomController::class, 'storeRoom'])->name('storeRoom');
        Route::get('/{id}/editRoom', [HotelRoomController::class, 'editRoom'])->name('editRoom');
        Route::patch('/{id}/updateRoom', [HotelRoomController::class, 'updateRoom'])->name('updateRoom');
        Route::delete('/{id}/destroyRoom', [HotelRoomController::class, 'destroyRoom'])->name('destroyRoom');
        Route::patch('/{id}/updateStatus', [HotelRoomController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}/viewRoom', [HotelRoomController::class, 'viewRoom'])->name('viewRoom');

        // カレンダー
        Route::get('/calendar', [HotelStaffController::class, 'calendar'])->name('calendar');
        Route::get('/calendar/data', [HotelStaffController::class, 'calendarData'])->name('calendar.data');
        // 予約一覧（日毎）
        Route::get('/reservations/{date}', [HotelStaffController::class, 'daily'])->name('reservations.date');
        Route::get('/reservations/detail/{id}', [HotelStaffController::class, 'show'])->name('reservations.show');
    });

    #################### Restaurant ####################
    Route::group(['prefix' => 'restaurant', 'as' => 'restaurant.', 'middleware' => 'restaurant'], function () {
        Route::get('/restauranthome', [StaffAnalysisController::class,'restaurantAnalysis'])->name('home');
        Route::get('/mypage', [StaffMypageController::class, 'indexRestaurant'])->name('mypage');
        Route::get('/mypage/edit', [StaffMypageController::class, 'editStaffMypagerestaurant'])->name('restaurant.edit');
        Route::put('/mypage/update', [StaffMypageController::class, 'updateStaffMypagerestaurant'])->name('update');

        #Restaurant - Table overview
        Route::get('/tableOverview', [RestaurantTableController::class, 'tableOverview'])->name('tableOverview');
        Route::post('/storeTableType', [RestaurantTableController::class, 'storeTableType'])->name('storeTableType');
        Route::patch('/{id}/updateTableType', [RestaurantTableController::class, 'updateTableType'])->name('updateTableType');
        Route::delete('/{id}/destroyTableType', [RestaurantTableController::class, 'destroyTableType'])->name('destroyTableType');
        Route::get('/createTable', [RestaurantTableController::class, 'createTable'])->name('createTable');
        Route::post('/storeTable', [RestaurantTableController::class, 'storeTable'])->name('storeTable');
        Route::get('/{id}/editTable', [RestaurantTableController::class, 'editTable'])->name('editTable');
        Route::patch('/{id}/updateTable', [RestaurantTableController::class, 'updateTable'])->name('updateTable');
        Route::delete('/{id}/destroyTable', [RestaurantTableController::class, 'destroyTable'])->name('destroyTable');
        Route::patch('/{id}/updateStatus', [RestaurantTableController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}/viewTable', [RestaurantTableController::class, 'viewTable'])->name('viewTable');

        // カレンダー
         Route::get('/calendar', [RestaurantStaffController::class, 'calendar'])->name('calendar');
         Route::get('/calendar/data', [RestaurantStaffController::class, 'calendarData'])->name('calendar.data');
        //  予約一覧
        Route::get('/reservations/{date}', [RestaurantStaffController::class, 'daily'])->name('reservations.date');
        Route::get('/reservations/detail/{id}', [RestaurantStaffController::class, 'show'])->name('reservations.show');
        
    });

    #################### User ####################
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
        Route::get('mypage/post',[MypageController::class,'post'])->name('mypage.post');

        Route::post('/user/mypage/delete-avatar', [MyPageController::class, 'deleteAvatar'])->name('delete.avatar');

        Route::get('/mypage/edit/adress', [MyPageController::class, 'editAdress'])->name('edit.adress');
        Route::post('/mypage/edit/updateAdress', [MyPageController::class, 'updateAdress'])->name('update.adress');
        Route::get('/mypage/edit/profile', [MyPageController::class,'editProfile'])->name('edit.profile');
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

//jeepney
Route::get('/jeepney', function () {
    return view('jeepney');
})->name('jeepney');
Route::get('/jeepney', [JeepneyController::class, 'index'])->name('jeepney.index');
Route::post('/jeepney/search', [JeepneyController::class, 'search'])->name('jeepney.search');
//game
Route::middleware(['auth'])->group(function () {
    Route::get('/daily-fortune', [DailyFortuneController::class, 'show'])->name('daily.fortune.show');
    Route::post('/daily-fortune/draw', [DailyFortuneController::class, 'draw'])->name('daily.fortune.draw');
});
