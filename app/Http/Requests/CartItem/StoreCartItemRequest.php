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
        $model = $this->getPurchasableModel();

        return [
            'type' => ['required', 'string', new ValidCartItem],
            'ids' => ['required', 'array'],
            'ids.*' => ['required_with:ids', 'integer', Rule::exists($model->getTable(), $model->getKeyName())]
        ];
    }

    public function getPurchasableModel()
    {
        $model = Relation::getMorphedModel($this->input('type')) ?? $this->input('type');

        return new $model;
    }
}
