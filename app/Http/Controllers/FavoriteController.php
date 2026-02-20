<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index(){
        return view('userpage.mypage.favorite');
    }

    public function store($type,$id) {
       Favorite::firstOrCreate([
            'user_id'       => Auth::id(),
            'target_type'   => $type,
            'target_id'     => $id
       ]);
       return back();
    }

    public function destroy($type, $id) {
       Favorite::where([
            'user_id'       => Auth::id(),
            'target_type'   => $type,
            'target_id'     => $id
       ])->delete();

       return back();
    }
}
