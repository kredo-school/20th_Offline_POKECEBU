<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function index() {
        $totalUsers = User::where('role_id', 3)->count();

        return view('adminpage.home', compact('totalUsers'));
    }

    public function customers()
    {
        return view('adminpage.customer.customers'); // Customer表用
    }

    public function hotels()
    {
        return view('adminpage.hotel.hotels'); // Hotel表用
    }
    
    public function addHotel()
    {
        return view('adminpage.hotel.add');
    }
      public function editHotel()
    {
        return view('adminpage.hotel.edit');
    }

    public function restaurants()
    {
        return view('adminpage.restaurant.restaurants'); // Restaurant表用
    }
    public function editRestaurant()
    {
        return view('adminpage.restaurant.edit');
    }
    public function addRestaurant(){
        return view('adminpage.restaurant.add');
    }

    public function admins()
    {
        // 管理者一覧ページのビュー
        return view('adminpage.admin.admin'); 
    }


    public function analysisHotel()
    {
        // 解析ページのロジックをここに追加
        return view('adminpage.hotel.analysis-hotel');
    }

    public function analysisRestaurant()
    {
        // 解析ページのロジックをここに追加
        return view('adminpage.restaurant.analysis-restaurant');
    }

    public function addAdmin()
    {   
        return view('adminpage.admin.add');
    }

    public function editAdmin()
    {
        return view('adminpage.admin.edit');
    }

    // AdminController.php
    public function editCustomer()
    {
        return view('adminpage.customer.edit-customers');
    }
    public function addCustomer()
    {
        return view('adminpage.customer.add-customers');
    }
}
