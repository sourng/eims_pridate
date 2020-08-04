<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;

class StudentsGuardians extends Model
{
    public static function getData($student_id)
    {
        if ($student_id) {
            $get = StudentsGuardians::where('student_id', $student_id)->get()->toArray();
            if ($get) {
                $data = array();
                foreach ($get as $row) {
                    $data[] = array(
                        'father'          => array(
                            'name'        => $row['father_fullname'],
                            'occupation'  => $row['father_occupation'],
                            'phone'       => $row['father_phone'],
                            'email'       => $row['father_email'],
                            'extra_info'  => $row['father_extra_info'],
                        ),
                        'mother'          => array(
                            'name'        => $row['mother_fullname'],
                            'occupation'  => $row['mother_occupation'],
                            'phone'       => $row['mother_phone'],
                            'email'       => $row['mother_email'],
                            'extra_info'  => $row['mother_extra_info'],
                        ),
                        'guardian_is'    => $row['guardian_is'],

                        'guardian'        => array(
                            'name'        => $row['guardian_fullname'],
                            'occupation'  => $row['guardian_occupation'],
                            'phone'       => $row['guardian_phone'],
                            'email'       => $row['guardian_email'],
                            'extra_info'  => $row['guardian_extra_info'],
                        ),

                    );
                }

                $response       = array(
                    'success'   => true,
                    'data'      => $data,
                );
            }
        }

        return $response;
    }

    public static function addToTable($student_id)
    {
        $response = false;
        try {
            $values = [
                'student_id'          => $student_id,
                'father_fullname'     => trim(request('father_fullname')),
                'father_occupation'   => trim(request('father_occupation')),
                'father_phone'        => trim(request('father_phone')),
                'father_email'        => trim(request('father_email')),
                'father_extra_info'   => trim(request('father_extra_info')),

                'mother_fullname'     => trim(request('mother_fullname')),
                'mother_occupation'   => trim(request('mother_occupation')),
                'mother_phone'        => trim(request('mother_phone')),
                'mother_email'        => trim(request('mother_email')),
                'mother_extra_info'   => trim(request('mother_extra_info')),
            ];

            if (strtolower(trim(request('guardian'))) == 'other_guardian') {
                $values = $values + [
                    'guardian_fullname'   => trim(request('guardian_fullname')),
                    'guardian_occupation' => trim(request('guardian_occupation')),
                    'guardian_phone'      => trim(request('guardian_phone')),
                    'guardian_email'      => trim(request('guardian_email')),
                    'guardian_extra_info' => trim(request('guardian_extra_info')),
                    'guardian_is'         => null
                ];
            } else {
                $values = $values + [
                    'guardian_fullname'   => null,
                    'guardian_occupation' => null,
                    'guardian_phone'      => null,
                    'guardian_email'      => null,
                    'guardian_extra_info' => null,
                    'guardian_is'         => strtolower(trim(request('guardian')))
                ];
            }

            $add = StudentsGuardians::insert($values);
            if ($add) {
                $response       = array(
                    'success'   => true,
                    'message'   => array(
                        'title' => Translator::phrase('success'),
                        'text'  => Translator::phrase('add.successfully'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                );
            }
        } catch (DomainException $e) {
            $response       = Exception::exception($e);
        }
        return $response;
    }

    public static function updateToTable($student_id)
    {
        $response = false;
        try {
            $values = [
                'student_id'          => $student_id,
                'father_fullname'     => trim(request('father_fullname')),
                'father_occupation'   => trim(request('father_occupation')),
                'father_phone'        => trim(request('father_phone')),
                'father_email'        => trim(request('father_email')),
                'father_extra_info'   => trim(request('father_extra_info')),

                'mother_fullname'     => trim(request('mother_fullname')),
                'mother_occupation'   => trim(request('mother_occupation')),
                'mother_phone'        => trim(request('mother_phone')),
                'mother_email'        => trim(request('mother_email')),
                'mother_extra_info'   => trim(request('mother_extra_info')),
            ];

            if (request('guardian') == 'other_guardian') {
                $values+= [
                    'guardian_fullname'   => trim(request('guardian_fullname')),
                    'guardian_occupation' => trim(request('guardian_occupation')),
                    'guardian_phone'      => trim(request('guardian_phone')),
                    'guardian_email'      => trim(request('guardian_email')),
                    'guardian_extra_info' => trim(request('guardian_extra_info')),
                    'guardian_is'         => null
                ];

            } else {
                $values['guardian_is']   =  request('guardian');
            }

            $update = StudentsGuardians::where('student_id', $student_id)->update($values);
            if ($update) {
                $response       = array(
                    'success'   => true,
                    'message'   => array(
                        'title' => Translator::phrase('success'),
                        'text'  => Translator::phrase('update.successfully'),
                        'button'   => array(
                            'confirm' => Translator::phrase('ok'),
                            'cancel'  => Translator::phrase('cancel'),
                        ),
                    ),
                );
            }
        } catch (DomainException $e) {
            $response       = Exception::exception($e);
        }
        return $response;
    }
}
