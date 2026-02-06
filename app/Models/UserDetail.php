<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
   // app/Models/UserDetail.php
protected $fillable = [
    'user_id',
    'first_name',
    'last_name',
    'birthday',
    'phone', // ←ここを 'phonenumber' から 'phone' に変更
    'street_address',
    'city',
    'state',
    'postal_code',
    // 'country',
];
    

    // Userとの関係
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
