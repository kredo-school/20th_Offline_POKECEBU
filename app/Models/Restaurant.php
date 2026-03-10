<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class Restaurant extends Model
{
    // id を手動で設定する場合は incrementing を false にする
    public $incrementing = false;

    // keyType は int のまま
    protected $keyType = 'int';
       
    use HasFactory;

    // 複数代入可能なカラム
    //
    protected $fillable = [
        'id',
        'name',
        'description',
        'address',
        'city',
        'latitude',
        'longitude',
        'star_rating',
        'phone',
        'website',
        'representative_name',
        'representative_email',
        'image_path',
        'owner_name',
        'email',
        'updated_user',
    ];

    /**
     * user リレーション（users.id と restaurants.id を結ぶ）
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    /**
     * 画像との関係
     */
    public function images()
    {
        return $this->hasMany(RestaurantImage::class, 'restaurant_id', 'id');
    }

    /**
     * テーブル（席）との関係
     */
    public function tables()
    {
        return $this->hasMany(RestaurantTable::class, 'restaurant_id', 'id');

    }
        
    

    // restaurant_images
    public function restaurantImages()
    {
        return $this->hasMany(RestaurantImage::class);
    }

    //お気に入り 
    // isFavorited をクラス名ベースで判定するように修正
    public function isFavorited(): bool
    {
        $userId = Auth::id();
        if (!$userId) return false;

        if ($this->relationLoaded('favorites')) {
            return $this->favorites->contains('user_id', $userId);
        }

        return \App\Models\Favorite::where('user_id', $userId)
            ->where('target_type', 'restaurant')   // 短名で照合
            ->where('target_id', $this->id)
            ->exists();
    }



    // 評価
    public function reviews() {
       return $this->hasMany(Review::class, 'target_id')
            ->where ('target_type', 'restaurant');;
    }

    // 評価済みかチェック
    public function reviewdBy($userId) {
       return $this->reviews()
            ->where('user_id', $userId)
            ->exists();
    }

    // 評価を取得
    public function reviewBy($userId) {
       return $this->reviews()
            ->where('user_id', $userId)
            ->first();
    }

    public function tmpRestaurants()
    {
        return $this->hasMany(TmpRestaurant::class, 'restaurant_id', 'id');
    }


    // Polymorphic favorites relation using target_type / target_id
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'target');
    }
}
