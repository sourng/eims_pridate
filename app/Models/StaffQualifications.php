<?php

namespace App\Models;

use DomainException;
use App\Helpers\Exception;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;

class StaffQualifications extends Model
{

    public static function getData($staff_id)
    {
        if ($staff_id) {
            try {
                $get = StaffQualifications::where('staff_id', $staff_id)->first();
                if ($get) {
                    $data[] = array(
                        'certificate' => StaffCertificate::getData($get['certificate_id'])['data'][0],
                        'extra_info'  => $get['extra_info']
                    );
                    $response       = array(
                        'success'   => true,
                        'data'      => $data,
                    );
                }
            } catch (DomainException $e) {
                $response       = Exception::exception($e);
            }
        }

        return $response;
    }


    public static function addToTable($staff_id)
    {
        $response = array();
        try {
            $add = StaffQualifications::insert([
                'staff_id' => $staff_id,
                'certificate_id' => request('staff_certificate'),
                'extra_info' => request('staff_certificate_info'),


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
            $add = StaffQualifications::where('staff_id',$staff_id)->update([
                'certificate_id' => request('staff_certificate'),
                'extra_info' => request('staff_certificate_info'),
            ]);
            if ($add) {
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
