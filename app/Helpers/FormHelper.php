<?php

namespace App\Helpers;

use App\Models\Users;

class FormHelper
{

    static public function form($data, $name, $formAction, $role = null)
    {
        if ($role == null) {
            $role =  Users::role();
        }

        return [
            'data' => $data,
            'name' => str_replace("/", "_", $name),
            'role' => FormHelper::roles($formAction),
            'action'  => [
                'detect' => url($role . '/' . $name . $formAction),
                'list'   => url($role . '/' . $name . '/list'),
                'add'    => url($role . '/' . $name . '/add/'),
                'edit'   => url($role . '/' . $name . str_replace(FormHelper::roles($formAction), 'edit', $formAction)),
                'view'   => url($role . '/' . $name . str_replace(FormHelper::roles($formAction), 'view', $formAction)),
                'delete' => url($role . '/' . $name . str_replace(FormHelper::roles($formAction), 'delete', $formAction)),

            ]
        ];
    }
    static public function roles($string)
    {
        $formRoles = ['add', 'edit', 'view', 'delete'];

        if (preg_match('/add/i', $string)) {
            $formRoles = 'add';
        } elseif (preg_match('/edit/i', $string)) {
            $formRoles = 'edit';
        } elseif (preg_match('/view/i', $string)) {
            $formRoles = 'view';
        } elseif (preg_match('/delete/i', $string)) {
            $formRoles = 'delete';
        } else {
            $formRoles = 'add';
        }
        return $formRoles;
    }
}
