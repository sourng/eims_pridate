<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStudyCourseSession extends FormRequest
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
            'study_course_schedule'      => 'required',
            'study_session'              => 'required',
            'study_start'                => 'required',
            'study_end'                  => 'required'
        ];
    }

    public static function attributeField()
    {
        return [

            'study_course_schedule'      => Translator::phrase('study_course_schedule'),
            'study_session'              => Translator::phrase('study_session'),
            'study_start'                => Translator::phrase('study_start'),
            'study_end'                  => Translator::phrase('study_end'),

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
