<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDetail;
use App\Models\HotelReservationDetail;


class MyPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load('detail');
        return view('userpage.mypage.mypage', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $user->load('detail');
        return view('userpage.mypage.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // 1. バリデーション 🛡️
        $request->validate([
            'first_name' => 'nullable|string|max:255',
        'last_name'  => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'avatar'     => 'nullable|image|mimes:jpeg,png,jpg,gif', // 画像バリデーション
        ]);

        $user = Auth::user();

        // 2. 保存データの配列
        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
        ];

        // 3. 画像がアップロードされていれば、base64化してDBに保存
      if ($request->hasFile('avatar')) {
    $file = $request->file('avatar');
    $data['avatar'] = 'data:image/' . $file->extension() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
    
    // ここで止めて確認！
   
}

        // 4. 更新 or 作成
        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect(route('mypage'))->with('success', 'Profile updated!');
    }
    public function editPersonal()
    {
        $user = Auth::user();
        $user->load('detail'); // detailをロードしておく
        return view('userpage.mypage.edit-personal', compact('user'));
    }

    public function updatePersonal(Request $request)
    {
        $request->validate([
            'first_name' => 'string|max:255',
            'last_name'  => 'string|max:255',
            'phone'      => 'nullable|string|max:20',
            'birthday'   => 'nullable|date',
        ]);


        $user = Auth::user();

        $detail = $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'      => $request->phone,
                'birthday'   => $request->birthday,
            ]
        );



        return redirect('/mypage');
    }
    public function editAdress()
    {
        $user = Auth::user();
        $user->load('detail');
        return view('userpage.mypage.edit-adress', compact('user'));
    }


    public function updateAdress(Request $request)
    {
        // 1. バリデーション
        $request->validate([
            'street_address' => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:100',
            'postal_code'    => 'required|string|max:100',
            // 'country'        => 'required|string|max:100',
        ]);

        $user = Auth::user();

        // 2. 保存処理
        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'street_address' => $request->street_address,
                'city'           => $request->city,
                'state'          => $request->state,
                'postal_code'    => $request->postal_code,
                // 'country'        => $request->country,
            ]
        );

        return redirect('/mypage');
    }


    
}

