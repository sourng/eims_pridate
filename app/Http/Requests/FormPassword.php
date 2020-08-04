<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormPassword extends FormRequest
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

    public static function rulesField()
    {
        $rules['old_password']               = 'required|min:6';
        $rules['password']                   = 'required|min:6';
        $rules['password_confirmation']      = 'required|min:6';
        return $rules;
    }

    public static function attributeField()
    {
        $attributes['old_password']                = Translator::phrase('old_password');
        $attributes['password']                    = Translator::phrase('new_password');
        $attributes['password_confirmation']       = Translator::phrase('password_confirm');

        return $attributes;
    }

    public static function questionField()
    {
        return [];
    }



    // validation.php // view/lang/en/validation.php
    public static function customMessages()
    {
        return [];
    }
}
