<?php

namespace App\Http\Requests;

use App\Models\UserCard;
use App\Rules\CheckPin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;


class CardReplenishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
        $rules = [
            'amount' => ['required', 'numeric', 'min:1'],
            'pin' => ['required', 'numeric', 'digits:4']
        ];
        /** @var UserCard $card */
        $card = Route::current()->parameter('card');
        if($card){
            $rules['pin'][] = new CheckPin($card);
        }

        return $rules;
    }
}
