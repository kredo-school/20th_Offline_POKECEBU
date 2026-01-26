<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MockReservationController extends Controller
{
   public function calendar() {
    // 1〜30日分のモックデータ
    $days = [];

    for($i=1; $i<=30; $i++){
        $days[$i] = [
            'available' => rand(0,5),    // 空室の数
            'in_use' => rand(0,5),       // 使用中
            'reserved' => rand(0,5),     // 予約済
            'maintenance' => rand(0,2)   // メンテナンス
        ];
    }

    return view('staffpage.calendar.calendar', compact('days'));
}

public function dayStatus($day) {
    // ダミー部屋番号
    $status = [
        'available' => range(101, 105),
        'in_use' => range(106, 110),
        'reserved' => range(111, 115),
        'maintenance' => range(116, 118)
    ];

    return view('staffpage.calendar.status', compact('day', 'status'));
}
public function detail($day, $type) {
    // ダミー部屋番号
    $rooms = [
        'available' => range(101, 105),
        'in_use' => range(106, 110),
        'reserved' => range(111, 115),
        'maintenance' => range(116, 118)
    ];

    $roomList = $rooms[$type] ?? [];

    return view('staffpage.calendar.detail', compact('day', 'type', 'roomList'));
}


}
