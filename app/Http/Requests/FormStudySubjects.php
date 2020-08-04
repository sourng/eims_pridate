<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStudySubjects extends FormRequest
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
        $rules['name']                     = 'required';
        $rules['course_type']              = 'required';
        if (config('app.languages')) {
            foreach (config('app.languages') as $lang) {
                $rules[$lang['code_name']] =  'required';
            }
        }
        $rules['full_mark_theory']         = 'required';
        $rules['pass_mark_theory']         = 'required';
        $rules['full_mark_practical']      = 'required';
        $rules['pass_mark_practical']      = 'required';
        $rules['credit_hour']              = 'required';
        //$rules['description']              = 'required';
        //$rules['image']                    = 'required';

        return $rules;
    }

    public static function attributeField()
    {

        $attributes['name']                     = Translator::phrase('study_subject_name');
        $attributes['course_type']              = Translator::phrase('course_type');
        if (config('app.languages')) {
            foreach (config('app.languages') as $lang) {
                $attributes[$lang['code_name']] =  Translator::phrase('study_subject.as.' . $lang['translate_name']);
            }
        }
        $attributes['full_mark_theory']         = Translator::phrase('full_mark_theory');
        $attributes['pass_mark_theory']         = Translator::phrase('pass_mark_theory');
        $attributes['full_mark_practical']      = Translator::phrase('full_mark_practical');
        $attributes['pass_mark_practical']      = Translator::phrase('pass_mark_practical');
        $attributes['credit_hour']              = Translator::phrase('credit_hour');
        $attributes['description']              = Translator::phrase('description');
        $attributes['image']                    = Translator::phrase('image');

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
