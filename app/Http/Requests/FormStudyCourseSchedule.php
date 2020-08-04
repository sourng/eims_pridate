<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStudyCourseSchedule extends FormRequest
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
            'institute'            => 'required',
            'study_program'        => 'required',
            'study_course'         => 'required',
            'study_generation'     => 'required',
            'study_academic_year'  => 'required',
            'study_semester'       => 'required',
            

        ];
    }

    public static function attributeField()
    {
        return [
            'institute'         => Translator::phrase('institute'),
            'study_program'         => Translator::phrase('study_program'),
            'study_course'         => Translator::phrase('study_course'),
            'study_generation'     => Translator::phrase('study_generation'),
            'study_academic_year'        => Translator::phrase('study_academic_year'),
            'study_semester'       => Translator::phrase('study_semester'),
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
