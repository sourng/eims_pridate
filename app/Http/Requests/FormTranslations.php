<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use App\Models\Languages;
use Illuminate\Foundation\Http\FormRequest;

class FormTranslations extends FormRequest
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
        return [
            'key'       => 'required',
            'en'        => 'required',
            'km'        => 'required',

        ];
    }
    public static function attributeField()
    {
        $attributes['phrase'] = Translator::phrase('phrase');
        if (config('app.languages')) {
            foreach (config('app.languages') as $lang) {
                $attributes[$lang['code_name']] =  Translator::phrase('word.in.' . $lang['translate_name']);
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
