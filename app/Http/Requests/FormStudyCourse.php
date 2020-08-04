<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStudyCourse extends FormRequest
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
        $rules['name'] = 'required';
        if (config('app.languages')) {
            foreach (config('app.languages') as $lang) {
                $rules[$lang['code_name']] =  'required';
            }
        }

        $rules['institute']                = 'required';
        //$rules['study_faculty']            = 'required';
        //$rules['course_type']              = 'required';
        //$rules['study_modality']           = 'required';
        $rules['study_program']            = 'required';
        //$rules['study_overall_fund']       = 'required';
        //$rules['curriculum_author']        = 'required';
        //$rules['curriculum_endorsement']   = 'required';
        //$rules['description']            = 'required';
        //$rules['image']                  = 'required';

        return  $rules;
    }

    public static function attributeField()
    {

            $attributes['name']                     = Translator::phrase('study_program_name');
            if (config('app.languages')) {
                foreach (config('app.languages') as $lang) {
                    $attributes[$lang['code_name']] =  Translator::phrase('study_academic_year.as.' . $lang['translate_name']);
                }
            }

            $attributes['institute']                = Translator::phrase('institute');
            $attributes['study_faculty']            = Translator::phrase('study_faculty');
            $attributes['course_type']              = Translator::phrase('course_type');
            $attributes['study_modality']           = Translator::phrase('study_modality');
            $attributes['study_program']            = Translator::phrase('study_program');
            $attributes['study_overall_fund']       = Translator::phrase('study_overall_fund');
            $attributes['curriculum_author']        = Translator::phrase('curriculum_author');
            $attributes['curriculum_endorsement']   = Translator::phrase('curriculum_endorsement');
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
