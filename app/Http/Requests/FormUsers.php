<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormUsers extends FormRequest
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
            'institute'     => 'required',
            'name'          => 'required',
            'phone'         => 'required',
            'email'         => 'required|email|max:255',
            'password'      => 'required|min:6',
            'address'       => 'required',
            'location'      => 'required',
            'role'          => 'required',
            //'profile'       => 'required',
        ];
    }

    public static function rulesField2()
    {
       return [
           'institute'             => 'required',
            'first_name_km'        => 'required|only_khmer_character|only_string',
            'last_name_km'         => 'required|only_khmer_character|only_string',
            'first_name_en'        => 'required|string',
            'last_name_en'         => 'required|string',
            'nationality'          => 'required',
            'mother_tong'          => 'required',
            // 'national_id'          => 'required',
            'gender'               => 'required',
            'date_of_birth'        => 'required',
            'marital'              => 'required',
            // 'teacher_or_student'   => 'required',
        ];
    }

    public static function attributeField()
    {
        return [
                'institute'    => Translator::phrase('institute'),
                'name'         => Translator::phrase('user_name'),
                'phone'        => Translator::phrase('phone'),
                'email'        => Translator::phrase('email'),
                'password'     => Translator::phrase('password'),
                'address'      => Translator::phrase('address'),
                'location'     => Translator::phrase('location'),
                'role'         => Translator::phrase('role'),
                'profile'      => Translator::phrase('profile'),

        ];
    }

    public static function questionField()
    {
        return [];
    }
    public static function customMessages()
    {
        return [];
    }
}
