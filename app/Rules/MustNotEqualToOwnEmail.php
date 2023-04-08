<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class MustNotEqualToOwnEmail implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $user = auth()->user();
        if($user->email == $value) {
            $fail('email must not be your own email');
        }
    }
}
