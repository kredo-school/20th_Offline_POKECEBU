<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDetail;
use App\Models\HotelReservationDetail;
use App\Models\Post;



class MyPageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load('detail');

        // MyPageController index
        $posts = Post::with('images', 'tags', 'likes', 'comments')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('userpage.mypage.mypage', compact('user', 'posts'));
    }
    public function isLiked()
    {
        if (!Auth::check()) return false; // 追加
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }


public function post()
{
    $user = auth()->user()->load('detail'); // ← 追加

    $home_posts = Post::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('userpage.mypage.post', compact('user', 'home_posts')); // ← user追加
}
    public function editProfile()
    {
        $user = Auth::user();
        $user->load('detail');
        return view('userpage.mypage.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // 1. バリデーション：mimesに jpg, jpeg のみを指定 🛡️
        $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:20',
            'avatar'     => 'nullable|image|mimes:jpg,jpeg|max:2048', // jpg, jpegのみ許可
        ], [
            'avatar.mimes' => 'Only JPG and JPEG formats are supported.',
            'avatar.max'   => 'The image size must not exceed 2MB.',
        ]);

        $user = Auth::user();
        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
        ];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $data['avatar'] = 'data:image/' . $file->extension() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $user->detail()->updateOrCreate(['user_id' => $user->id], $data);

        return redirect()->route('user.mypage')->with('success', 'Profile updated!');
    }

    // --- 追加：写真を削除する機能 ---
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->detail) {
            $user->detail->update(['avatar' => null]);
        }

        return redirect()->back()->with('success', 'Profile photo deleted.');
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
