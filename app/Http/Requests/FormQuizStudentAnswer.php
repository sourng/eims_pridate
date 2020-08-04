<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormQuizStudentAnswer extends FormRequest
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
            'quiz_student'         => 'required',
            'quiz_question'        => 'required',
            'answer'.$flag               => 'required',
        ];

        return $rules;
    }

    public static function attributeField($flag = '[]')
    {
        $attributes = [
            'answer'.$flag            => Translator::phrase('answer'),
        ];

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
