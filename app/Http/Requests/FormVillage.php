<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormVillage extends FormRequest
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

        $rules['province']  = 'required';
        $rules['district']  = 'required';
        $rules['commune']   = 'required';
        $rules['name']      = 'required';
        if (config('app.languages')) {
            foreach (config('app.languages') as $lang) {
                $rules[$lang['code_name']] =  'required';
            }
        }
        //$rules['description']   = 'required';
        //$rules['image']         = 'required';
        return $rules;
    }

    public static function attributeField()
    {
        $attributes['province']  = Translator::phrase('province');
        $attributes['district']  = Translator::phrase('district');
        $attributes['commune']   = Translator::phrase('commune');
        $attributes['name']      = Translator::phrase('village');

        if (config('app.languages')) {
            foreach (config('app.languages') as $lang) {
                $attributes[$lang['code_name']] =  Translator::phrase('village.as.' . $lang['translate_name']);
            }
        }

        $attributes['description'] = Translator::phrase('description');
        $attributes['image']       = Translator::phrase('image');

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
