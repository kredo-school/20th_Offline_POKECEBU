<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategory extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'soft_order'];

    public function faqs() {
        return $this->hasMany(Faq::class, 'faq_category_id');
    }
}
