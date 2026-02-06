<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $post;

    public function __construct(Post $post)
    {
        // $this->middleware('auth');
        $this->post = $post;
       
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // Homeにポストを表示させる
    public function index()
    {
        $home_posts = $this->getHomePosts();
        return view('home')
        ->with('home_posts',$home_posts);
        
    }

    public function getHomePosts() {
       return $this->post->latest()->take(3)->get();
      
    }
    
}
