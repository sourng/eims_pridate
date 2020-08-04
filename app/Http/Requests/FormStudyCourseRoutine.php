<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStudyCourseRoutine extends FormRequest
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
            'study_course_session'       => 'required',
            'start_time'.$flag           => 'required',
            'end_time'.$flag             => 'required',
            'day'.$flag                  => 'required',
            'teacher'.$flag              => 'required',
            'study_subject'.$flag        => 'required',
            'study_class'.$flag          => 'required',

        ];
    }

    public static function attributeField($flag = '[]')
    {
        return [
            'study_course_session'       => Translator::phrase('study_course_session'),
            'start_time'.$flag           => Translator::phrase('start_time'),
            'end_time'.$flag             => Translator::phrase('end_time'),
            'day'.$flag                  => Translator::phrase('day'),
            'teacher'.$flag              => Translator::phrase('teacher'),
            'study_subject'.$flag        => Translator::phrase('study_subject'),
            'study_class'.$flag          => Translator::phrase('study_class'),
        ];
    }

    public static function questionField()
    {
        return array();
    }



    // validation.php // view/lang/en/validation.php
    public static function customMessages()
    {
        return array();
    }
}
