<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // 実テーブル名に合わせる
    protected $table = 'hotel_rooms';

    protected $fillable = [
        'hotel_id',
        'name',
        'max_guests',
        'charges',
        // 他のカラム
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'room_id');
    }

    /**
     * 指定期間に予約が入っていない（空室）ルームを絞るスコープ
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Carbon\Carbon|string $checkin
     * @param \Carbon\Carbon|string $checkout
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailableBetween($query, $checkin, $checkout)
    {
        // Carbon インスタンスでも文字列でも扱えるようにする
        $ci = \Carbon\Carbon::parse($checkin)->startOfDay();
        $co = \Carbon\Carbon::parse($checkout)->endOfDay();

        return $query->whereDoesntHave('reservations', function ($q) use ($ci, $co) {
            $q->where(function ($r) use ($ci, $co) {
                $r->whereBetween('start_at', [$ci, $co])
                    ->orWhereBetween('end_at', [$ci, $co])
                    ->orWhere(function ($s) use ($ci, $co) {
                        $s->where('start_at', '<=', $ci)->where('end_at', '>=', $co);
                    });
            });
        });
    }

   
}
