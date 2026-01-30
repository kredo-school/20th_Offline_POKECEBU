<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;

    protected $fillable = ['faq_category_id', 'title', 'question', 'answer', 'soft_order'];

    public function category() {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }
}
