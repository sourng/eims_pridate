<?php

namespace App\Rules;

use Dotenv\Regex\Result;
use App\Helpers\Translator;
use Illuminate\Contracts\Validation\Rule;

class KhmerCharacter implements Rule
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
    public function passes($attribute, $char)
    {

        $character = array();
        $result = false;
        $allow = [32];
        $from  = 6016;
        $to = 6099;


        for ($i = $from; $i <= $to; $i++) {
            $allow[] = $i;
        }


        preg_match_all('/./u', $char, $character);
        foreach ($character[0] as $key => $value) {
            if (in_array($this->characterCode($value), $allow)) {
                $result = true;
                continue;
            } else {
                $result = false;
                break;
            }
        }

        return $result;
    }

    public function characterCode($char)
    {
        $k = mb_convert_encoding(trim($char), 'UCS-2LE', 'UTF-8');
        $k1 = ord(substr($k, 0, 1));
        $k2 = ord(substr($k, 1, 1));
        return $k2 * 256 + $k1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute ' . Translator::phrase('required_khmer_only');
    }
}
