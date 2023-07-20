<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllowedStringName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        if(trim($value)=="" || $value==null){
            return true;
        }
        $value = str_replace("ñ", "n", $value);
        $value = str_replace("Ñ", "N", $value);
        $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        return preg_match('/^[\pL\pM_ _-_-_.]+$/u', $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute field has invalid characters.';
    }
}
