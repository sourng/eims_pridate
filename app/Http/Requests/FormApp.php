<?php

namespace App\Http\Requests;

use App\Helpers\Translator;

use App\Rules\KhmerCharacter;
use Illuminate\Foundation\Http\FormRequest;

class FormApp extends FormRequest
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
        $rules = [
                'name'                                            => 'required',
                'phone'                                           => 'required|regex:/^([0-9\(\)\/\+ \-]*)$/|min:9',
                'email'                                           => 'required|email|min:10|max:50',
                'address'                                         => 'required',
                'website'                                         => 'required',
                //'logo'                                          => 'required',
                //'favicon'                                       => 'required',
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
        $attributes = [
                'name'                                            => Translator::phrase('app_name'),
                'phone'                                           => Translator::phrase('phone'),
                'email'                                           => Translator::phrase('email'),
                'address'                                         => Translator::phrase('address'),
                'website'                                         => Translator::phrase('website'),
                'logo'                                            => Translator::phrase('logo'),
                'favicon'                                         => Translator::phrase('favicon'),
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
