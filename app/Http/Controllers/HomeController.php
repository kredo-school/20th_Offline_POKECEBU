<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Post;
use App\Models\Hotel;
use App\Models\PostTag;
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
        $hotelRankings      = $this->getHotelRankings();
        $restaurantRankings = $this->getRestaurantRankings();
        $hotelsByCity       = $this->getHotelsByCity();
        $home_posts         = $this->getHomePosts();
        $popularTags        = $this->getPopularTags();
        $weather           = $this->getWeather();
        $rate              = $this->getRate();

        return view('home',compact(
            'hotelRankings',
            'restaurantRankings',
            'hotelsByCity',
            'home_posts',
            'popularTags',
            'weather',
            'rate'
            ));
        
    }

    // ホテルランキング
    public function getHotelRankings() {
       return Hotel::orderBy('star_rating', 'desc')
            ->take(3)
            ->get();
    }
    
    // レストランランキング
    public function getRestaurantRankings() {
       return Restaurant::orderBy('star_rating','desc')
            ->take(3)
            ->get();
    }

    // 都市別ホテル
    public function getHotelsByCity() {
       return Hotel::orderBy('star_rating','desc')
            ->get()
            ->groupBy('city')
            ->map(function ($hotels) {return $hotels->take(3);
            });
    }

    // ポスト
    public function getHomePosts() {
       return $this->post->latest()->take(3)->get();
    }

    // 人気タグ
    public function getPopularTags() {
       return PostTag::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(10)
            ->get();
    }

    // 天気予報
    public function getWeather() {
       return Http::get('https://api.openweathermap.org/data/2.5/weather',[
        'q'     => 'Cebu,PH',
        'appid' => config('services.openweather.key'),
        'units' => 'metric',
        'lang' => 'ja',
       ])->json();
    }

    // 為替レート
    public function getRate() {
       $response = Http::get("https://v6.exchangerate-api.com/v6/".env('EXCHANGE_API_KEY')."/latest/JPY");

       if ($response->successful()) {
        $rate = $response->json();
        return $rate["conversion_rates"]["PHP"] ?? null;
       }
        return null;
    }

}
