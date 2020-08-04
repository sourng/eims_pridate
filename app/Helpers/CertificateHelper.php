<?php

namespace App\Helpers;


use App\Models\CertificateFrames;
use Illuminate\Support\Facades\Session;

class CertificateHelper
{
    public static function make($arrayObject)
    {

        $certificate       = Session::get('certificate');
        $certificateFrame         = CertificateFrames::getData(CertificateFrames::where("status", 1)->first()->id, true)["data"][0];
        $certificate_front = Session::has('certificate_front') ? (Session::get('certificate_front')) : $certificateFrame["front_o"];
        $certificate_back  = Session::has('certificate_back') ? (Session::get('certificate_back')) : $certificateFrame["background"];
        $layout     = ($certificate && $certificate["settings"]["layout"]) ? $certificate["settings"]["layout"] : $certificateFrame["layout"];

        $allcertificates = array();
        $certificateContainer = [
            'width'  => ($layout ==  'vertical') ? 1000 : 700,
            'height' => ($layout ==  'vertical') ?  700 : 250,
        ];
        $certificate_front = [
            'x'     => 0,
            'y'     => 0,
            'width' => ($layout ==  'vertical') ? 1000 : 2481,
            'height' => ($layout ==  'vertical') ? 700 : 250,
            'image' => $certificate_front
        ];


        $certificate_back  = [
            'x'     => ($layout ==  'vertical') ? 252 : 352,
            'y'     => 0,
            'width' => ($layout ==  'vertical') ? 700 : 2481,
            'height' => ($layout ==  'vertical') ? 700 : 250,
            'image' => $certificate_back
        ];

        $textColor = '#23499E';
        if ($arrayObject['success']) {
            foreach ($arrayObject["data"] as $row) {

                $certificateTmp = $certificate && $certificate["attributes"] ? $certificate["attributes"] : CertificateFrames::FrameData();
                $certificateData  = array();
                foreach ($certificateTmp  as $key => $tmp) {
                    if (array_key_exists($key, $row)) {
                        $obj = array();
                        $x = $certificateContainer["width"] / 2;
                        $y = $certificateContainer["height"] / 2;
                        $fontFamily = "NiDAKhmerEmpire";
                        $fontStyle = "normal";
                        $visible = false;
                        $draggable = false;

                        if ($key == "fullname") {
                            $x = $layout == "vertical" ? 213 : 180;
                            $y = $layout == "vertical" ? 299 : 80;
                            $fontFamily = "KhmerOSMoul";
                            $fontStyle = "bold";
                            $visible = true;
                        } else if ($key == "_fullname") {
                            $x = $layout == "vertical" ? 635 : 180;
                            $y = $layout == "vertical" ? 302 : 102;
                            $fontFamily = "KhmerOSMoul";
                            $fontStyle = "bold";
                            $visible = true;
                        } else if ($key == "program") {
                            $x = $layout == "vertical" ? 270 : 180;
                            $y = $layout == "vertical" ? 370 : 148;
                            $visible = true;
                        } else if ($key == "_program") {
                            $x = $layout == "vertical" ? 665 : 180;
                            $y = $layout == "vertical" ? 370 : 148;
                            $visible = true;
                        } else if ($key == "course") {
                            $x = $layout == "vertical" ? 196 : 180;
                            $y = $layout == "vertical" ? 391 : 148;
                            $visible = true;
                        } else if ($key == "_course") {
                            $x = $layout == "vertical" ? 575 : 180;
                            $y = $layout == "vertical" ? 393 : 148;
                            $visible = true;
                        } else if ($key == "dob") {
                            $x = $layout == "vertical" ? 210 : 180;
                            $y = $layout == "vertical" ? 324 : 162;
                            $visible = true;
                        } else if ($key == "_dob") {
                            $x = $layout == "vertical" ? 630 : 180;
                            $y = $layout == "vertical" ? 324 : 162;
                            $visible = true;
                        } else if ($key == "photo") {
                            $x = $layout == "vertical" ? 475  : 20;
                            $y = $layout == "vertical" ? 487 : 76;
                            $visible = true;
                        }

                        if ($key == "photo" || $key == "qrcode") {
                            $obj =  array(
                                'attrs' => [
                                    'x'       => $x,
                                    'y'       => $y,
                                    'width'   => $key == "photo" ? 75 : 90,
                                    'height'  => $key == "photo" ? 85 : 90,
                                    'source'  => $row[$key],
                                    'visible' => $visible,
                                    'name'    => $key,
                                    'id'      => $key,
                                ],
                                'className' => 'Image',
                            );
                            if ($tmp && gettype($tmp) == "array") {
                                $tmp["attrs"]['source']  = $row[$key];
                                $tmp["attrs"]['draggable']  = $draggable;
                                $obj = $tmp;
                            }
                        } else {

                            $obj =  array(
                                'attrs' => [
                                    'x'          => $x,
                                    'y'          => $y,
                                    'text'       => $row[$key],
                                    'fill'       => $textColor,
                                    'fontSize'   => 14,
                                    'fontFamily' => $fontFamily,
                                    'fontStyle'  => $fontStyle,
                                    'width'      => 150,
                                    'height'     => 14,
                                    'visible'    => $visible,
                                    'name'       => $key,
                                    'id'         => $key,
                                ],
                                'className' => 'Text',
                            );

                            if ($tmp && gettype($tmp) == "array") {
                                $tmp["attrs"]['text']  = $row[$key];
                                $tmp["attrs"]['draggable']  = $draggable;
                                $obj = $tmp;
                            }
                        }

                        $certificateData[] = $obj;
                    }
                }

                $makecertificate = [
                    'id' => $row["id"],
                    'attrs' => [
                        'width'  => $certificateContainer["width"],
                        'height' => $certificateContainer["height"],
                    ],
                    'className' => 'Stage',
                    'children' =>
                    [
                        [
                            'attrs' => [],
                            'className' => 'Layer',
                            'children'  => [
                                [
                                    'attrs' =>
                                    [
                                        'x'      => $certificate_front['x'],
                                        'y'      => $certificate_front['y'],
                                        'width'  => $certificate_front['width'],
                                        'height' => $certificate_front['height'],
                                        'source' => $certificate_front['image'],
                                    ],
                                    'className' => 'Image',
                                ],

                                [
                                    'attrs' =>
                                    [
                                        'x'      => $certificate_back['x'],
                                        'y'      => $certificate_back['y'],
                                        'width'  => $certificate_back['width'],
                                        'height' => $certificate_back['height'],
                                        'source' => $certificate_back['image'],
                                    ],
                                    'className' => 'Image',
                                ],
                            ],
                        ],

                        [
                            'attrs' => [],
                            'className' => 'Layer',
                            'children'  => $certificateData,
                        ],
                    ],
                ];

                $allcertificates[] = $makecertificate;
            }
            return array(
                'success'   => true,
                'data'      => $allcertificates,
                'settings'  => $certificate && $certificate["settings"] ? $certificate["settings"] : [
                    "layout" => "vertical"
                ],
                "frame" => $certificateFrame,
            );
        }


        return array(
            'success'   => false,
            'data'      => $allcertificates,
            'settings'  => $certificate && $certificate["settings"] ? $certificate["settings"] : [
                "layout" => "vertical"
            ],
            "frame" => $certificateFrame,
        );
    }
}
