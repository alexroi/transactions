<?php

namespace App\Rules;

use App\Models\UserCard;
use Illuminate\Contracts\Validation\Rule;

class CheckAmount implements Rule
{
    private $card;

    /**
     * Create a new rule instance.
     *
     * @param UserCard $card
     * @return void
     */
    public function __construct(UserCard $card)
    {
        $this->card = $card;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($value > $this->card->cash){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cash for transfer exceeds balance of your card.';
    }
}
