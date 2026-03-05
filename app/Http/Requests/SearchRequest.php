<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'destination' => 'nullable|string|max:255',
            'checkin'     => 'nullable|date',
            'checkout'    => 'nullable|date|after:checkin',
            'adults'      => 'nullable|integer|min:1',
            'rooms'       => 'nullable|integer|min:1',
            'amenities'   => 'nullable|array',
            'amenities.*' => 'integer|exists:categories,id',
            'sort'        => 'nullable|string|in:recommended,price_asc,price_desc,rating',
        ];
    }
    protected function prepareForValidation()
    {
        if ($this->has('sort')) {
            $this->merge([
                'sort' => trim($this->input('sort')),
            ]);
        }
    }
}
