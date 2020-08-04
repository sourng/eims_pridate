<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class FormSponsored extends FormRequest
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
        $rules["name"]          = "required";
        $rules["link"]          = "required";
        // $rules["image"]         = "required";
        //$rules["description"]   = "required";
        return $rules;
    }

    public static function attributeField()
    {

        $attributes["name"]       = Translator::phrase('name');
        $attributes["link"]        = Translator::phrase('link');
        $attributes["image"]       = Translator::phrase('image');
        $attributes["description"] = Translator::phrase('description');
        return $attributes;
    }

    public static function questionField(){
        return [];
    }



    // validation.php // view/lang/en/validation.php
    public static function customMessages()
    {
        return [];
    }
}
