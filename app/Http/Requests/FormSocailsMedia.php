<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormSocailsMedia extends FormRequest
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
        $rules = [
            'facebook'      => 'required',
            'linkedin'      => 'required',
            'google-plus'   => 'required',
            'whatsapp'      => 'required',
            'pinterest'     => 'required',
            'twitter'       => 'required',
            'youtube'       => 'required',
            'instagram'     => 'required',
            'skype'         => 'required',
            'wordpress'     => 'required',
            'tripadvisor'   => 'required',
            'rss'           => 'required',
            'like-cambodia' => 'required',
            'github'        => 'required',
        ];
        return $rules;
    }

    public static function attributeField()
    {
        $attributes = [
            'facebook'      =>  Translator::phrase('facebook'),
            'linkedin'      =>  Translator::phrase('linkedin'),
            'google-plus'   =>  Translator::phrase('google_plus'),
            'whatsapp'      =>  Translator::phrase('whatsapp'),
            'pinterest'     =>  Translator::phrase('pinterest'),
            'twitter'       =>  Translator::phrase('twitter'),
            'youtube'       =>  Translator::phrase('youtube'),
            'instagram'     =>  Translator::phrase('instagram'),
            'skype'         =>  Translator::phrase('skype'),
            'wordpress'     =>  Translator::phrase('wordpress'),
            'tripadvisor'   =>  Translator::phrase('tripadvisor'),
            'rss'           =>  Translator::phrase('rss'),
            'like-cambodia' =>  Translator::phrase('like_cambodia'),
            'github'        =>  Translator::phrase('github'),
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
