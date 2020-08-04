<?php

namespace App\Http\Controllers\Staff;

use App\Models\App;
use App\Models\Roles;
use App\Models\Staff;
use App\Models\Users;
use App\Models\Gender;
use App\Models\Marital;
use App\Models\Communes;
use App\Models\Villages;
use App\Models\Districts;
use App\Models\Institute;
use App\Models\Languages;
use App\Models\Provinces;
use App\Models\BloodGroup;
use App\Models\MotherTong;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\Nationality;
use App\Models\StaffStatus;
use App\Models\SocailsMedia;
use App\Http\Requests\FormStaff;
use App\Models\StaffCertificate;
use App\Models\StaffDesignations;
use App\Models\StaffTeachSubject;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Staff\StaffCertificateController;
use App\Http\Controllers\Staff\StaffDesignationController;
use App\Models\StaffInstitutes;

class StaffController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }

    public function index($param1 = null, $param2 = null, $param3 = null, $param4 = null)
    {        
        $data['formAction']          = '/add';
        $data['formName']            = Staff::$path['url'];
        $data['title']               = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']           = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']            = url(Users::role() . '/' . $param1);
        $data['formData']            = array(
            'photo'                  => asset('/assets/img/user/male.jpg'),
        );
        $data['listData']            = array();

        if (strtolower($param1) == null) {
            $data['shortcut'] = [
                [
                    'name'  => Translator::phrase('add.staff'),
                    'link'  => url(Users::role() . '/' . Staff::$path['url'] . '/add'),
                    'icon'  => 'fas fa-user-plus',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('add.staff.short_form'),
                    'link'  => url('staff-register'),
                    'target' => '_blank',
                    'icon'  => 'fas fa-user-plus',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.staff.all'),
                    'link'  => url(Users::role() . '/' . Staff::$path['url'] . '/list'),
                    'icon'  => 'fas fa-users-class',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.designation'),
                    'link'  => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffDesignations::$path['url'] . '/list'),
                    'icon'  => 'fas fa-user-tie',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.staff_status'),
                    'link'  => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffStatus::$path['url'] . '/list'),
                    'icon'  => 'fas fa-question-square',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.staff_certificate'),
                    'link'  => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffCertificate::$path['url'] . '/list'),
                    'icon'  => 'fas fa-file-certificate',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.staff_teach_subject'),
                    'link'  => url(Users::role() . '/' . Staff::$path['url'] . '/' . StaffTeachSubject::$path['url'] . '/list'),
                    'icon'  => 'fas fa-chalkboard-teacher',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ],

            ];
            $data['view']  = Staff::$path['view'] . '.includes.dashboard.index';
            $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .staff. & .teacher');
        } elseif (strtolower($param1) == 'list') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  Staff::getData(null, null, 10, request('search'));
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  Staff::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'add') {

            if (request()->method() === 'POST') {
                return Staff::addToTable();
            }


            $data = $this->show($data, null, $param1);
        } elseif (strtolower($param1) == 'view') {
            $id = request('id', $param2);
            $data = $this->show($data, $id, $param1);
            $data['view']  = Staff::$path['view'] . '.includes.view.index';
        } elseif (strtolower($param1) == 'print') {
            $id = request('id', $param2);
            if ($id) {
                $data['response'] = Staff::getData($id, true);
                $data['view']  = Staff::$path['view'] . '.includes.print.index';
            } else {
                $data = $this->list($data);
            }
        } elseif (strtolower($param1) == 'edit') {

            $id = request('id', $param2);
            if (request()->method() === 'POST') {
                return Staff::updateToTable($id);
            }
            $data = $this->show($data, $id, $param1);
        } elseif (strtolower($param1) == 'delete') {
            $id = request('id', $param2);
            return Staff::deleteFromTable($id);
        } elseif (strtolower($param1) == 'account') {
            $id = $param3 ? $param3 : request('id');
            if ($param2 == 'create') {

                if (request()->method() == "POST") {
                    return Staff::createAccountToTable($id);
                }

                $data =  $this->account($data, $id, $param2);
            }
        } elseif (strtolower($param1) == StaffDesignations::$path['url']) {
            $view = new StaffDesignationController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1) == StaffStatus::$path['url']) {
            $view = new StaffStatusController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1) == StaffCertificate::$path['url']) {
            $view = new StaffCertificateController();
            return $view->index($param2, $param3, $param4);
        } elseif (strtolower($param1) == StaffTeachSubject::$path['url']) {
            $view = new StaffTeachSubjectController();
            return $view->index($param2, $param3, $param4);
        } else {
            abort(404);
        }

        MetaHelper::setConfig(
            [
                'title'       => $data['title'],
                'author'      => config('app.name'),
                'keywords'    => '',
                'description' => '',
                'link'        => $data['metaLink'],
                'image'       => $data['metaImage']
            ]
        );

        $pages = array(
            'host'       => url('/'),
            'path'       => '/' . Users::role(),
            'pathview'   => '/' . $data['formName'] . '/',
            'parameters' => array(
                'param1' => $param1,
                'param2' => $param2,
                'param3' => $param3,
            ),
            'search'     => parse_url(request()->getUri(), PHP_URL_QUERY) ? '?' . parse_url(request()->getUri(), PHP_URL_QUERY) : '',
            'form'       => FormHelper::form($data['formData'], $data['formName'], $data['formAction']),
            'parent'     => Staff::$path['view'],
            'modal'      => Staff::$path['view'] . '.includes.modal.index',
            'view'       => $data['view'],
        );

        $pages['form']['validate'] = [
            'rules'       => strtolower($param1) == 'account' ? [] : FormStaff::rulesField(),
            'attributes'  => strtolower($param1) == 'account' ? [] : FormStaff::attributeField(),
            'messages'    => strtolower($param1) == 'account' ? [] : FormStaff::customMessages(),
            'questions'   => strtolower($param1) == 'account' ? [] : FormStaff::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);

        return view(Staff::$path['view'] . '.index', $data);
    }

    public function list($data)
    {
        $staff = Staff::join((new StaffInstitutes())->getTable(), (new StaffInstitutes())->getTable() . '.staff_id', (new Staff())->getTable() . '.id');
        if (request('instituteId')) {
            $staff = $staff->where('institute_id', request('instituteId'))
                ->whereNotIn('designation_id', [1]);
        }
        $data['response'] = [
            'gender'      => Staff::gender($staff),
            'staffStatus' => Staff::staffStatus($staff),
        ];



        $data['view']  = Staff::$path['view'] . '.includes.list.index';
        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.' . $data['formName']);
        return $data;
    }

    public function show($data, $id, $type)
    {

        $data['institute']           = Institute::getData();
        $data['status']              = StaffStatus::getData();
        $data['designation']         = StaffDesignations::getData();
        $data['mother_tong']         = MotherTong::getData();
        $data['gender']              = Gender::getData();
        $data['nationality']         = Nationality::getData();
        $data['marital']             = Marital::getData();
        $data['blood_group']         = BloodGroup::getData();
        $data['provinces']           = Provinces::getData();
        $data['districts']           = Districts::getData('null');
        $data['communes']            = Communes::getData('null');
        $data['villages']            = Villages::getData('null');
        $data['staff_certificate']   = StaffCertificate::getData();
        $data['curr_districts']      = $data['districts'];
        $data['curr_communes']       = $data['communes'];
        $data['curr_villages']       = $data['villages'];

        $data['view']       = Staff::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $type . '.' . $data['formName']);


        if ($id) {
            $response           = Staff::getData($id, true);
            $data['formData']   = $response['data'][0];
            $data['listData']   = $response['pages']['listData'];
            $data['formAction'] = '/' . $type . '/' . $id;

            $data['metaImage']  = asset('assets/img/icons/' . $type . '.png');
            $data['metaLink']   = url(Users::role() . $data['formAction']);
            $pob                = $data['formData']['place_of_birth'];
            $cur                = $data['formData']['current_resident'];

            if ($pob['district']) {
                $data['communes'] = Communes::getData($pob['district']['id']);
            }
            if ($pob['commune']) {
                $data['villages'] = Villages::getData($pob['commune']['id']);
            }

            if ($cur['district']) {
                $data['curr_communes'] = Communes::getData($cur['district']['id']);
            }
            if ($cur['commune']) {
                $data['curr_villages'] = Villages::getData($cur['commune']['id']);
            }
        }






        return $data;
    }


    public function account($data, $id, $type)
    {
        $response           = Staff::getData($id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/account/' . $type . '/' . $response['data'][0]['id'];
        $data['view']       = Staff::$path['view'] . '.includes.account.index';
        if ($data['formData']['staff_institute']['designation']['id'] == 1) {
            $data['role']       = Roles::getData(request('roleId', 1));
            $data['formData']['role']['id']   = 1;
        } elseif (in_array($data['formData']['staff_institute']['designation']['id'], [2, 3])) {
            $data['role']       = Roles::getData(request('roleId', 8));
            $data['formData']['role']['id']   = 8;
        } else {
            $data['role']       = Roles::getData(request('roleId', Staff::$path['roleId']));
            $data['formData']['role']['id']   = Staff::$path['roleId'];
        }

        return $data;
    }
}
