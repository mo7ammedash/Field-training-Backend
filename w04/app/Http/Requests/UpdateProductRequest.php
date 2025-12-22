<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => [
                'required',
                Rule::unique('products', 'name')->ignore($this->product),
            ],
            'price' => 'required|numeric|gt:0',
        ];
    }
}
