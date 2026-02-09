<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDetail;

class MyPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load('detail');
        return view('userpage.mypage.mypage', compact('user'));
    }

    public function editProfile(){
        $user = Auth::user();
        $user->load('detail');
        return view('userpage.mypage.edit-profile', compact('user'));
    }
    
public function updateProfile(Request $request)
{
    // 1. バリデーション 🛡️
    $request->validate([
        'first_name' => 'nullable|string|max:255',
        'last_name'  => 'required|string|max:255',
        'phone'      => 'nullable|string|max:20',
    ]);

    $user = Auth::user();

    // 2. 保存処理 💾
    // 第1引数で「誰のデータか」を指定し、第2引数で「何を保存するか」を指定します
    $user->detail()->updateOrCreate(
        ['user_id' => $user->id], // 検索条件
        [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
        ]
    );

    // 3. リダイレクト 🏠
    return redirect('/mypage')->with('success', 'Profile updated!');
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
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'required|string|max:255',
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
