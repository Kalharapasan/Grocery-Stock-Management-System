<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $this->route('product')->id,
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'unit' => 'required|string|in:kg,pcs,litre,pack,dozen',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
        ];
    }
}
