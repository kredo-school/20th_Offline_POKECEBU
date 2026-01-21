<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminHomeController extends Controller
{
    public function index()
    {
        // 上部の統計
        $totalUsers = 3; // 仮（後でDBから取得）
        $pageViews  = 12430; // 仮（後でGAなどと連携）

        return view('adminpage.home', compact('totalUsers', 'pageViews'));
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