<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|min:3|max:255',
            'price' => 'bail|required|numeric|gt:0',
            'sale_price' => 'bail|numeric|gte:0|lte:price',
            'image' => 'bail|required|mimes:png,jpg,jpeg,jfif,webp,svg'
        ];
    }
}
