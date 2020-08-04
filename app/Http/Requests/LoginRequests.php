<?php

namespace App\Http\Requests;

use App\Helpers\Translator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequests extends FormRequest
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
    public static function customRules()
    {
        return [
                'email'    => 'required|email|max:255',
                'password' => 'required|min:6',
        ];
    }

    public static function customAttributes()
    {
        return [
                'email'    => Translator::phrase('email'),
                'password' => Translator::phrase('password'),
        ];
    }

    public static function customMessages()
    {
        return [];
    }
}
