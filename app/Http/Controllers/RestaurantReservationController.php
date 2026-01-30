<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RestaurantReservationController extends Controller
{

    public function __construct() {
       
    }

    public function show($id) {
        // 仮データ（後でDBから取得できる形にする）
        return view('staff.reservation.info',[
            'reservationId' => $id
        ]);
       
    }
}
