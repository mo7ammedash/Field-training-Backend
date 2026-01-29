<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('products', 'name')->ignore($this->product->id),
            ],
            'price'       => 'required|numeric|gt:0',
            'category_id' => 'required|exists:categories,id',
            'suppliers'   => 'required|array',

            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {

            if (!$this->has('suppliers')) {
                $validator->errors()->add(
                    'suppliers',
                    'Please select at least one supplier and fill cost & lead time.'
                );
                return;
            }

            $selected = collect($this->suppliers)
                ->filter(fn($s) => isset($s['selected']));

            if ($selected->isEmpty()) {
                $validator->errors()->add(
                    'suppliers',
                    'Please select at least one supplier and fill cost & lead time.'
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
