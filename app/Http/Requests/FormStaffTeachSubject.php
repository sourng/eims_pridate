<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStaffTeachSubject extends FormRequest
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
        $rules['staff']          = 'required';
        $rules['study_subject']   = 'required';
        $rules['year']   = 'required';
        return $rules;
    }

    public static function attributeField()
    {
        $attributes['staff']          = Translator::phrase('staff');
        $attributes['study_subject']   = Translator::phrase('study_subject');
        $attributes['year']   = Translator::phrase('year');

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
