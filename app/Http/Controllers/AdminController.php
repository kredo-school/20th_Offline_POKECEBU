<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Restaurant;
use App\Models\User;

class AdminController extends Controller
{
    public function index() {
        $totalUsers = User::where('role_id', 3)->count();

        return view('adminpage.home', compact('totalUsers'));
    }

    // Customer関連
    // User 一覧

// ===============================
// Customer追加フォーム
// ===============================
// ===============================
// Customer 一覧
// ===============================
public function customer()
{
    // role_id が 1 のユーザーだけを取得
    $customers = User::where('role_id', 1)->get();
    return view('adminpage.customer.customers', compact('customers'));
}

// ===============================
// Customer 追加画面
// ===============================
public function addCustomer()
{
        $totalUsers = User::count();
    return view('adminpage.customer.add-customers',compact('totalUsers'));
}

// ===============================
// Customer 保存
// ===============================
public function storeCustomer(Request $request)
{
        $totalUsers = User::count();
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role_id' => 1, // ★ Customer固定
    ]);

    return redirect()->route('admin.customer')->with('success', 'Customer added!');
}

// ===============================
// Customer 編集画面
// ===============================
public function editCustomer($id)
{
        $totalUsers = User::count();
    // 編集対象も role_id が 1 のユーザーに限定して取得
    $user = User::where('role_id', 1)->findOrFail($id);
    return view('adminpage.customer.edit-customers', compact('user','totalUsers'));
}

// ===============================
// Customer 更新
// ===============================
public function updateCustomer(Request $request, $id)
{
        $totalUsers = User::count();
    // 更新対象も role_id が 1 に限定
    $user = User::where('role_id', 1)->findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => "required|email|unique:users,email,{$id}",
        'password' => 'nullable|string|min:6',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    
    if ($request->password) {
        $user->password = bcrypt($request->password);
    }
    
    $user->save();

    return redirect()->route('admin.customer')->with('success', 'Customer updated!');
}

// ===============================
// Customer 削除
// ===============================
public function deleteCustomer($id)
{
    // 削除対象も role_id が 1 に限定
    $user = User::where('role_id', 1)->findOrFail($id);
    $user->delete();

    return redirect()->route('admin.customer')->with('success', 'Customer deleted!');
}

    // ホテル一覧
    public function hotels()
    {
        $hotels = Hotel::all();
        return view('adminpage.hotel.hotels', compact('hotels')); // Hotel表用
    }

    // ホテル追加画面
    public function addHotel()
    {
        return view('adminpage.hotel.add');
    }

    // ホテル保存処理
    public function storeHotel(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        Hotel::create($data);

        return redirect()->route('admin.hotels')->with('success', 'Hotel added!');
    }

    // ホテル編集画面
    public function editHotel($id)
    {
        $hotel = Hotel::findOrFail($id);
        return view('adminpage.hotel.edit', compact('hotel'));
    }

    // ホテル更新処理
    public function updateHotel(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        $hotel->update($data);

        return redirect()->route('admin.hotels')->with('success', 'Hotel updated!');
    }

    // ホテル削除
    public function deleteHotel($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();

        return redirect()->route('admin.hotels')->with('success', 'Hotel deleted!');
    }

    // Restaurant関連
   public function restaurants()
{
    $restaurants = Restaurant::all();
    $totalUsers = User::count(); // 全ユーザー数を取得

    return view('adminpage.restaurant.restaurants', compact('restaurants', 'totalUsers'));
}


    // レストラン追加フォーム
    public function addRestaurant()
    {    $totalUsers = User::count();
        return view('adminpage.restaurant.add', compact('totalUsers'));
    }

    // レストラン保存
    public function storeRestaurant(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        Restaurant::create($data);

        return redirect()->route('admin.restaurants')->with('success', 'Restaurant added!');
    }

    // レストラン編集フォーム
    public function editRestaurant($id)
    {    $totalUsers = User::count();
        $restaurant = Restaurant::findOrFail($id);
        return view('adminpage.restaurant.edit', compact('restaurant,totalUsers'));
    }

    // レストラン更新
    public function updateRestaurant(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
    $totalUsers = User::count();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
        ]);

        $restaurant->update($data);

        return redirect()->route('admin.restaurants')->with('success', 'Restaurant updated!');
    }

    // レストラン削除
    public function deleteRestaurant($id)
    {    $totalUsers = User::count();
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();

        return redirect()->route('admin.restaurants')->with('success', 'Restaurant deleted!');
    }
    // Admin関連


public function admins()
{
    $admins = User::where('role_id', 2)->get(); // 管理者だけ取得
    $totalUsers = User::count(); // 全ユーザー数を取得

    return view('adminpage.admin.admin', compact('admins', 'totalUsers'));
}

   public function addAdmin()
{
    $totalUsers = User::count();
    return view('adminpage.admin.add', compact('totalUsers')); // ← ここで渡す
}


// Admin 保存
public function storeAdmin(Request $request)
{    $totalUsers = User::count();
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role_id' => 2, // ★ Admin固定
    ]);

    return redirect()->route('admin.admins')->with('success', 'Admin added!');
}

// ===============================
// Admin 編集画面
// ===============================
public function editAdmin($id)
{
    $totalUsers = User::count();
    $admin = User::where('role_id', 2)->findOrFail($id);
    return view('adminpage.admin.edit', compact('admin', 'totalUsers')); // ← 追加
}


// Admin 更新
public function updateAdmin(Request $request, $id)
{    $totalUsers = User::count();
    $admin = User::where('role_id', 2)->findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => "required|email|unique:users,email,{$id}",
        'password' => 'nullable|min:6',
    ]);

    $admin->name = $request->name;
    $admin->email = $request->email;
    if ($request->password) {
        $admin->password = bcrypt($request->password);
    }
    $admin->save();

    return redirect()->route('admin.admins')->with('success', 'Admin updated!');
}

// ===============================
// Admin 削除
// ===============================
public function deleteAdmin($id)
{
    $admin = User::where('role_id', 2)->findOrFail($id);
    $admin->delete();

    return redirect()->route('admin.admins')->with('success', 'Admin deleted!');
}

    // 分析ページ（例）
    public function analysisHotel()
    {
        return view('adminpage.hotel.analysis-hotel');
    }
    public function analysisRestaurant()
    {
        return view('adminpage.restaurant.analysis-restaurant');
    }
}
