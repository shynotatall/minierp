<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // allow all authenticated users
    }

public function rules(): array
{
    $productId = $this->route('product') ? $this->route('product')->id : null;

    return [
        'name' => 'required|string|max:255',
        'sku' => 'required|string|max:100|unique:products,sku,' . $productId,
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
    ];
}
}
