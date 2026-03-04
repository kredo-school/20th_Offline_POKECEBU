<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like) {
      $this->like = $like; 
    }

    public function store($post_id) {
       $this->like->user_id = Auth::id();
       $this->like->post_id =$post_id;
       $this->like->save();

       if (request()->wantsJson()) {
        return response()->json(['status' => 'added']);
       }

       return back();
       
    }
    

    public function destroy($post_id) {
       $this->like
            ->where('user_id', Auth::id())
            ->where('post_id',$post_id)
            ->delete();
        
            if(request()->wantsJson()) {
             return response()->json(['status' => 'removed']);
            }

            return back();
       
    }
}
