<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormProfile extends FormRequest
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
        $rules['name']       = 'required';
        $rules['email']      = 'required';
        $rules['phone']      = 'required';
        $rules['address']    = 'required';
        $rules['location']   = 'required';
        return $rules;
    }

    public static function attributeField()
    {
        $attributes['name']        = Translator::phrase('name');
        $attributes['email']       = Translator::phrase('email');
        $attributes['phone']       = Translator::phrase('phone');
        $attributes['address']     = Translator::phrase('address');
        $attributes['location']    = Translator::phrase('location');
        $attributes['profile']     = Translator::phrase('profile');
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
