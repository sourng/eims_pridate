<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;


class FormCard extends FormRequest
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
            'institute'                     => 'required',
            'type'                          => 'required',
            'name'                          => 'required',
            'layout'                        => 'required',
        ];
    }

    public static function attributeField()
    {
        return [
            'institute'                     => Translator::phrase('institute'),
            'type'                          => Translator::phrase('type'),
            'name'                          => Translator::phrase('name'),
            'layout'                        => Translator::phrase('layout'),
            'front'                         => Translator::phrase('frame_front'),
            'background'                    => Translator::phrase('frame_background'),
            'extra_info'                    => Translator::phrase('extra_info'),

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
