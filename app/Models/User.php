<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


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

    // （2/6 User クラス内の protected $fillable を次のように変更）
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // 追加：承認時に role を設定するため
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
    
    public function hotel()
    {
        return $this->hasOne(Hotel::class, 'id', 'id');
    }

    // （User クラス内に restaurant() を追加）
    public function restaurant()
    {
        return $this->hasOne(Restaurant::class, 'id', 'id');
    }
}
