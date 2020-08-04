<?php

namespace App\Http\Controllers\Images;

use App\Models\App;
use App\Models\Staff;
use App\Models\Students;
use App\Helpers\QRHelper;
use App\Models\CardFrames;
use App\Helpers\ImageHelper;
use App\Models\StudentsRequest;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;
use App\Models\StudentsShortCourseRequest;

class ImagesController extends Controller
{
    protected $response;
    public function __construct()
    {
        $this->response = response()->json(
            array(
                'success' => false,
                'message'  => 'Bad URL timestamp'
            )
        );
    }

    public function index($param1 = null, $param2 = null, $param3 = null)
    {

        if (strtolower($param1) == Staff::$path['image']) {
            $this->response = ImageHelper::getImage($param2, Staff::$path['image'], request('type'), request('w'), request('h'), request('q'));
        } else if (strtolower($param1) == Students::$path['image']) {
            if (in_array($param2, [
                StudentsStudyCourse::$path['image'],
                QRHelper::$path['image'],
                CardFrames::$path['image'],
                StudentsRequest::$path['image'],
                StudentsShortCourseRequest::$path['image'],
            ])) {
                $this->response = ImageHelper::getImage($param3, Students::$path['image'] . '/' . $param2, request('type'));
            } else {
                $this->response = ImageHelper::getImage($param2, Students::$path['image'], request('type'), request('w'), request('h'), request('q'));
            }
        } else if (strtolower($param1) == QRHelper::$path['image']) {
            $this->response = ImageHelper::getImageNoType($param2, QRHelper::$path['image']);
        } else {
            $this->response = ImageHelper::getImage($param2, $param1, request('type'), request('w'), request('h'), request('q'));
        }

        return $this->response;
    }
}
