<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserDetail;
use App\Models\HotelReservation;
use App\Models\RestaurantReservation; // 追加
use App\Models\Post;
use App\Models\Favorite;
use App\Models\Hotel;
use App\Models\Restaurant;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    
    const USER_ROLE_ID = 1;
    const ADMIN_ROLE_ID = 2;
    const HOTEL_ROLE_ID = 3;
    const RESTAURANT_ROLE_ID = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'phonenumber',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    // --- リレーションシップ ---

    public function hotel()
    {
        return $this->hasOne(Hotel::class, 'id', 'id');
    }

    public function restaurant()
    {
        return $this->hasOne(Restaurant::class, 'id', 'id');
    }

    public function posts() 
    {
        return $this->hasMany(Post::class);
    }

    public function detail() 
    {
        return $this->hasOne(UserDetail::class);
    }

    /**
     * ホテル予約のリレーション (分析で使用)
     */
    public function hotelReservations() 
    {
        return $this->hasMany(HotelReservation::class);
    }

    /**
     * レストラン予約のリレーション (分析で使用)
     */
    public function restaurantReservations()
    {
        return $this->hasMany(RestaurantReservation::class);
    }
    
    // 旧来のメソッド名維持用
    public function reservations() 
    {
        return $this->hasMany(HotelReservation::class);
    }

    public function favorites() {
       return $this->hasMany(Favorite::class);
    }

    // --- 分析用スタティックメソッド ---

    public static function getNewUserStats($hotelId = null)
    {
        $query = self::where('role_id', 1);

        if ($hotelId) {
            $query->where('hotel_id', $hotelId);
        }

        $currentMonthCount = (clone $query)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $labels = [];
        $counts = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $labels[] = $month->format('M');
            $counts[] = (clone $query)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();
        }

        return [
            'count' => $currentMonthCount,
            'chart' => [
                'labels' => $labels,
                'data' => $counts
            ]
        ];
    }
}