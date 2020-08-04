<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStudySubjectLesson extends FormRequest
{
    /**
     * Determine if the user is authorized to make this required.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the required.
     *
     * @return array
     */

    public static function rulesField()
    {
        $rules['title']                  = 'required';
        $rules['staff_teach_subject']    = 'required';
        //$rules['source_file']            = 'required';

        return $rules;
    }

    public static function attributeField()
    {
        $attributes['title']               = Translator::phrase('title');
        $attributes['staff_teach_subject']      = Translator::phrase('subject');
        $attributes['source_file']         = Translator::phrase('file');

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
