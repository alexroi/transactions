<?php

namespace App\Rules;

use App\Models\UserCard;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class CheckPin implements Rule
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
        return Hash::check($value, $this->card->pin);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Wrong pin number.';
    }
}
