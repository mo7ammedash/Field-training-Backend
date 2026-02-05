<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|unique:products,name',
            'price'       => 'required|numeric|gt:0',
            'category_id' => 'required|exists:categories,id',
            'suppliers'   => 'required|array',

            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {

            $suppliers = $this->input('suppliers', []);

            $selected = collect($suppliers)
                ->filter(fn($s) => isset($s['selected']));

            if ($selected->isEmpty()) {
                $validator->errors()->add(
                    'suppliers',
                    'Please select at least one supplier.'
                );
            }

            foreach ($selected as $id => $supplier) {

                if (empty($supplier['cost_price'])) {
                    $validator->errors()->add(
                        "suppliers.$id.cost_price",
                        'Cost price is required.'
                    );
                }

                if (empty($supplier['lead_time_days'])) {
                    $validator->errors()->add(
                        "suppliers.$id.lead_time_days",
                        'Lead time days is required.'
                    );
                }
            }
        });
    }
}
