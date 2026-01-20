<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return view('adminpage.admin-home'); // 初期ページ
    }

    public function customers() {
        return view('adminpage.customers'); // Customer表用
    }

    public function hotels() {
        return view('adminpage.hotels'); // Hotel表用
    }

    public function restaurants() {
        return view('adminpage.restaurants'); // Restaurant表用
    }

    public function admins() {
        return view('adminpage.admin'); // Admin表用
    }
}
