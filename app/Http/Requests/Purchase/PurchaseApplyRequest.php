<?php

namespace App\Http\Requests\Purchase;

use App\Emulator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseApplyRequest extends FormRequest
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
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $accountIds = $this->user()->gameAccounts->map->account_id->toArray();

        $validator->sometimes('character_id', Rule::exists('skyfire_characters.characters', 'guid')->whereIn('account', $accountIds), function ($input) {
            return filled($input->character_id);
        });

        $validator->after(function ($validator) {
            //
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'emulator' => [
                'required',
                'string',
                Rule::in(Emulator::supported())
            ],

            'character_id' => [
                'required',
                'integer',
            ]
        ];
    }
}
