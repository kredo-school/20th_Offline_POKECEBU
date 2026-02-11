<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalHistory extends Model
{
    //// 必要に応じてテーブル名を明示
    // protected $table = 'approval_histories';

    /**
     * Mass assignable attributes
     *
     * approvable_type がログに出ていたエラーの原因なので必ず含める
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'approvable_type',
        'approvable_id',
        'approved_by',
        'notes',
    ];

    /**
     * キャスト（必要なら追加）
     *
     * @var array<string,string>
     */
    protected $casts = [
        'approvable_id' => 'integer',
        'approved_by' => 'integer',
    ];

    /**
     * Polymorphic relation を使う場合のヘルパー（任意）
     */
    public function approvable()
    {
        return $this->morphTo();
    }
}
