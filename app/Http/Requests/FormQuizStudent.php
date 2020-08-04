<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormQuizStudent extends FormRequest
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

        $rules['quiz']  = 'required';
        return $rules;
    }

    public static function attributeField()
    {
        $attributes = [
            'study_course_session' => Translator::phrase('study_course_session'),
            'student'              => Translator::phrase('student'),
        ];
        $attributes['quiz']    = Translator::phrase('quiz_group');
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
