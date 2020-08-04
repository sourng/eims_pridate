<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStudentsStudyCourseScore extends FormRequest
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
        $rules = [
            'student'            => 'required',
            'study_subject'.$flag      => 'required',
            'attendance_marks'   => 'required',
            'other_marks'        => 'required',

        ];

        return  $rules;
    }

    public static function attributeField($flag = '[]')
    {
        return [
            'student'        => Translator::phrase('student'),
            'study_subject'.$flag        => Translator::phrase('study_subject'),
            'attendance_marks'     => Translator::phrase('attendance_marks'),
            'other_marks'          => Translator::phrase('other_marks'),
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
