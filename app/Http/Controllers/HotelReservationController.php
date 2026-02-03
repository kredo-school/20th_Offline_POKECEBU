<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HotelReservationController extends Controller
{
<<<<<<< HEAD
    //
=======
    public function index()
    {
        return view('reservations.hotel');
    public function __construct() {
       
    }
    public function show($id) {
        //仮データ（あとからDBから取得する形にする）
        return view('staff.reservation.info',[
            'reservationId' => $id
        ]);
    }
>>>>>>> main
}
