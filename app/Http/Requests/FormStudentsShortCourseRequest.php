<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStudentsShortCourseRequest extends FormRequest
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
            'institute'           => 'required',
            'student'.$flag       => 'required',
            'study_subject'       => 'required',
            'study_session'       => 'required',

        ];
    }

    public static function attributeField($flag = '[]')
    {
        return [
            'institute'   => Translator::phrase('institute'),
            'student'.$flag   => Translator::phrase('student'),
            'study_subject' => Translator::phrase('study_subject'),
            'study_session' => Translator::phrase('study_session'),

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
