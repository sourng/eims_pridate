<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStudentsStudyShortCourse extends FormRequest
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

    public static function rulesField($flag = '[]')
    {
        return [
            'student' . $flag               => 'required',
            'study_short_course_session'        => 'required',

        ];
    }

    public static function attributeField($flag  = '[]')
    {
        return [
            'student' . $flag    => Translator::phrase('student'),
            'study_short_course_session' => Translator::phrase('short_course_session'),

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
