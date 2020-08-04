<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStudentsRequest extends FormRequest
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
        $rules['institute']           = 'required';
        $rules['study_program']       = 'required';
        $rules['study_course']        = 'required';
        $rules['study_generation']    = 'required';
        $rules['study_academic_year'] = 'required';
        $rules['study_semester']      = 'required';
        $rules['study_session']       = 'required';
        return  $rules;
    }

    public static function attributeField()
    {

        $attributes['institute']          = Translator::phrase('institute');
        $attributes['study_program']      = Translator::phrase('study_program');
        $attributes['study_course']       = Translator::phrase('study_course');
        $attributes['study_generation']   = Translator::phrase('study_generation');
        $attributes['study_academic_year']= Translator::phrase('study_academic_year');
        $attributes['study_semester']     = Translator::phrase('study_semester');
        $attributes['study_session']      = Translator::phrase('study_session');
        $attributes['photo']              = Translator::phrase('photo');

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
