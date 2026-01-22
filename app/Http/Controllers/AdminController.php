<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        $totalUsers = 3;
        $pageViews  = 12430;

        return view('adminpage.home', compact('totalUsers', 'pageViews'));
    }

    public function customers() {
        return view('adminpage.customers');
    }

    public function hotels() {
        return view('adminpage.hotels');
    }

    public function restaurants() {
        return view('adminpage.restaurants');
    }

    public function admins() {
        return view('adminpage.admin');
    }

    public function analysisHotel()
    {
        // 解析ページのロジックをここに追加
        return view('adminpage.analysis-hotel');
    }

    public function analysisRestaurant()
    {
        // 解析ページのロジックをここに追加
        return view('adminpage.analysis-restaurant');
    }
}
