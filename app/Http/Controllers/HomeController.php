<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Hotel;
use App\Models\Restaurant;


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

   
    public function index()
    {
        $home_posts     = $this->getHomePosts();
        $hotelsByCity   = $this->getHotelsByCity();
        $hotelRankings   = $this->getHotelRankings();
        $restaurantRankings = $this->getRestaurantRankings();

        return view('home',compact(
            'home_posts',
            'hotelsByCity',
            'hotelRankings',
            'restaurantRankings'
            ));
        
    }

    public function getHomePosts() {
       return $this->post->latest()->take(3)->get();
      
    }

    public function getHotelsByCity() {
       return Hotel::orderBy('star_rating','desc')
            ->get()
            ->groupBy('city')
            ->map(function ($hotels) {return $hotels->take(3);
            });
    }

    public function getHotelRankings() {
       return Hotel::orderBy('star_rating', 'desc')
            ->take(3)
            ->get();
    }
    
    public function getRestaurantRankings() {
       return Restaurant::orderBy('star_rating','desc')
            ->take(3)
            ->get();
    }
}
