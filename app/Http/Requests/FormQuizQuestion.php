<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormQuizQuestion extends FormRequest
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
        $rules['quiz']   = 'required';
        $rules['quiz_type']   = 'required';
        $rules['quiz_answer_type']   = 'required';
        $rules['question']   = 'required';
        $rules['marks']   = 'required';
        return $rules;
    }

    public static function attributeField()
    {
        $attributes['quiz']    = Translator::phrase('quiz_group');
        $attributes['quiz_type']    = Translator::phrase('quiz_type');
        $attributes['quiz_answer_type']    = Translator::phrase('quiz_answer_type');
        $attributes['question']    = Translator::phrase('quiz_question');
        $attributes['marks']    = Translator::phrase('marks');

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
