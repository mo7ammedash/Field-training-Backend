<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:products,name',
            'price' => 'required|numeric|min:0.01',

            'suppliers' => 'required|array',

            'suppliers.*.selected' => 'sometimes|accepted',

            'suppliers.*.cost_price' =>
            'required_if:suppliers.*.selected,1|numeric|min:0',

            'suppliers.*.lead_time_days' =>
            'required_if:suppliers.*.selected,1|integer|min:0',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $suppliers = $this->input('suppliers', []);

            $selectedCount = collect($suppliers)
                ->filter(fn($s) => isset($s['selected']))
                ->count();

            if ($selectedCount === 0) {
                $validator->errors()->add(
                    'suppliers',
                    'You must select at least one supplier.'
                );
            }
        });
    }
}
