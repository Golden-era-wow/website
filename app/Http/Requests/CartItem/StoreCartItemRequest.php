<?php

namespace App\Http\Requests\CartItem;

use App\Rules\ValidCartItem;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCartItemRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'product_ids' => ['required', 'array'],
            'product_ids.*' => ['required_with:product_ids', 'integer', 'exists:products,id']
        ];
    }
}
