<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormSettingsColor extends FormRequest
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
            'id'         => 'required',
            'color'      => 'required',

        ];
    }

    public static function attributeField()
    {
        return [
            'id'         => Translator::phrase('numbering'),
            'color'      => Translator::phrase('color'),
         ];
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
