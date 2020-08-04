<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormTranslates extends FormRequest
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
        $rules =  [
            'phrase'  => 'required',
        ];

        if (config('app.languages')) {
            foreach (config('app.languages') as $lang) {
                $rules[$lang['code_name']] =  'required';
            }
        }
        return $rules;
    }

    public static function attributeField()
    {

        $attributes =  [
            'phrase'  => Translator::phrase('phrase'),
        ];
        if (config('app.languages')) {
            foreach (config('app.languages') as $lang) {
                $attributes[$lang['code_name']] =  Translator::phrase('app_name.as.' . $lang['translate_name']);
            }
        }
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
