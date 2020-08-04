<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;

class StaffInstitutes extends Model
{

    public static function getData($staff_id)
    {
        $response       = array(
            'success'   => false,
            'data'      => [],
        );

        if ($staff_id) {
            $get = StaffInstitutes::where('staff_id', $staff_id)->get()->toArray();
            if ($get) {
                $data = array();
                foreach ($get as $row) {
                    $data[] = array(
                        'institute'   => Institute::getData($row['institute_id'])['data'][0],
                        'designation' => StaffDesignations::getData($row['designation_id'])['data'][0],
                        'extra_info' => $row['extra_info'],
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





    public static function addToTable($staff_id)
    {
        $response = array();
        try {
            $add = StaffInstitutes::insert([
                'staff_id' => $staff_id,
                'institute_id' => trim(request('institute')),
                'designation_id' => trim(request('designation')),
                'extra_info' => trim(request('institute_extra_info')),
            ]);
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
    public static function updateToTable($staff_id)
    {
        $response = array();
        try {
            $update = StaffInstitutes::where('staff_id',$staff_id)->update([
                'institute_id' => trim(request('institute')),
                'designation_id' => trim(request('designation')),
                'extra_info' => trim(request('institute_extra_info')),
            ]);
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
