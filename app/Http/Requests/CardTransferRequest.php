<?php

namespace App\Http\Requests;

use App\Models\UserCard;
use App\Rules\CheckAmount;
use App\Rules\CheckPin;
use App\Rules\CheckSameCard;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CardTransferRequest extends FormRequest
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
            'number' => ['required', 'numeric', 'digits:16', 'exists:users_cards,number'],
            'pin' => ['required', 'numeric', 'digits:4']
        ];
        /** @var UserCard $card */
        $card = Route::current()->parameter('card');
        if($card){
            $rules['amount'][] = new CheckAmount($card);
            $rules['number'][] = new CheckSameCard($card);
            $rules['pin'][] = new CheckPin($card);
        }

        return $rules;
    }
}
