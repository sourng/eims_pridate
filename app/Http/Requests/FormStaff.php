<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class FormStaff extends FormRequest
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
            'status'               => 'required',
            'designation'          => 'required',
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

            'pob_province_fk'         => 'required',
            'pob_district_fk'         => 'required',
            'pob_commune_fk'          => 'required',
            'pob_village_fk'          => 'required',
            //'permanent_address'       => 'required',

            'curr_province_fk'     => 'required',
            'curr_district_fk'     => 'required',
            'curr_commune_fk'      => 'required',
            'curr_village_fk'      => 'required',
            //'temporaray_address'   => 'required',

            'father_fullname'      => 'required|only_string',
            'father_occupation'    => 'required',
            //'father_phone'         => 'required|regex:/^([0-9\(\)\/\+ \-]*)$/|min:9',
            // 'father_email'         => 'required|email',
            // 'father_extra_info'    => 'required',

            'mother_fullname'      => 'required|only_string',
            'mother_occupation'    => 'required',
            //'mother_phone'         => 'required|regex:/^([0-9\(\)\/\+ \-]*)$/|min:9',
            // 'mother_email'         => 'required|email',
            // 'mother_extra_info'    => 'required',

            'guardian'             => 'required',
            '__guardian'          => json_encode([
                'other'             => [
                    'guardian_fullname'    => 'required|only_string',
                    'guardian_occupation'  => 'required',
                    //'guardian_phone'       => 'required|regex:/^([0-9\(\)\/\+ \-]*)$/|min:9',
                    // 'guardian_email'       => 'required|email',
                    // 'guardian_extra_info'  => 'required',
                ]
            ]),

            'phone'                => 'required|regex:/^([0-9\(\)\/\+ \-]*)$/|min:9',
            'email'                   => 'required|email',
            // 'password'                => 'required|min:6',
            // 'staff_extra_info'   => 'required',
            //  'photo'                => 'required|image|mimes:jpeg,jpg,bmp,png|max:1024',
        ];
    }

    public static function attributeField()
    {
        return [

            'institute'            => Translator::phrase('institute'),
            'status'               => Translator::phrase('status'),
            'designation'          => Translator::phrase('designation'),
            'institute_extra_info' => Translator::phrase('extra_info'),

            'first_name_km'        => Translator::phrase('first_name_km'),
            'last_name_km'         => Translator::phrase('last_name_km'),
            'first_name_en'        => Translator::phrase('first_name_en'),
            'last_name_en'         => Translator::phrase('last_name_en'),

            'nationality'          => Translator::phrase('nationality'),
            'mother_tong'          => Translator::phrase('mother_tong'),
            'national_id'          => Translator::phrase('national_id'),

            'gender'               => Translator::phrase('gender'),
            'date_of_birth'        => Translator::phrase('date_of_birth'),
            'marital'              => Translator::phrase('marital'),

            'pob_province_fk'      => Translator::phrase('province'),
            'pob_district_fk'      => Translator::phrase('district'),
            'pob_commune_fk'       => Translator::phrase('commune'),
            'pob_village_fk'       => Translator::phrase('village'),
            'permanent_address'    => Translator::phrase('permanent_address'),

            'curr_province_fk'     => Translator::phrase('province'),
            'curr_district_fk'     => Translator::phrase('district'),
            'curr_commune_fk'      => Translator::phrase('commune'),
            'curr_village_fk'      => Translator::phrase('village'),
            'temporaray_address'   => Translator::phrase('temporaray_address'),

            'father_fullname'      => Translator::phrase('father_fullname'),
            'father_occupation'    => Translator::phrase('occupation'),
            'father_phone'         => Translator::phrase('father_phone'),
            'father_email'         => Translator::phrase('father_email'),
            'father_extra_info'    => Translator::phrase('extra_info'),

            'mother_fullname'      => Translator::phrase('mother_fullname'),
            'mother_occupation'    => Translator::phrase('occupation'),
            'mother_phone'         => Translator::phrase('mother_phone'),
            'mother_email'         => Translator::phrase('mother_email'),
            'mother_extra_info'    => Translator::phrase('extra_info'),

            'guardian'             => Translator::phrase('guardian'),

            'guardian_fullname'    => Translator::phrase('guardian_fullname'),
            'guardian_occupation'  => Translator::phrase('occupation'),
            'guardian_phone'       => Translator::phrase('guardian_phone'),
            'guardian_email'       => Translator::phrase('guardian_email'),
            'guardian_extra_info'  => Translator::phrase('extra_info'),
            'phone'                => Translator::phrase('phone'),
            'email'                => Translator::phrase('email'),
            'password'             => Translator::phrase('password'),
            'staff_extra_info'    => Translator::phrase('extra_info'),
            'photo'                => Translator::phrase('photo'),
        ];
    }

    public static function questionField()
    {
        return [];
    }




    // validation.php // view/lang/en/validation.php
    public static function customMessages()
    {
        return [
            'first_name_km'                                       => [
                'only_khmer_character'                            => Translator::phrase('first_name_km.required_only_khmer_character'),
            ],
            'last_name_km'                                        => [
                'only_khmer_character'                            => Translator::phrase('first_name_km.required_only_khmer_character'),
            ],
        ];
    }
}
