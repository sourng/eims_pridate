<?php

namespace App\Http\Controllers\Certificate;


use App\Models\App;
use App\Models\Users;
use App\Models\Students;
use App\Models\Institute;
use App\Models\Languages;
use App\Models\CertificateFrames;
use App\Helpers\CertificateHelper;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\SocailsMedia;
use App\Http\Requests\FormCertificate;
use App\Models\StudentsStudyCourse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CertificateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }

    public function index($param1 = 'list', $param2 = null, $param3 = null)
    {
        $data['institutes']      = Institute::getData();
        $data['formData'] = array(
            'front' => asset('/assets/img/certificate/front.png'),
            'background' => asset('/assets/img/certificate/background.png'),
        );
        $data['formAction']      = '/add';
        $data['formName']        = Students::$path['url'] . '/' . CertificateFrames::$path['url'];
        $data['title']           = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        $data['metaImage']       = asset('assets/img/icons/' . $param1 . '.png');
        $data['metaLink']        = url(Users::role() . '/' . $param1);
        $data['listData']       = array();
        if ($param1 == 'list' || $param1 == null) {
            $data = $this->list($data);
        } elseif (strtolower($param1) == 'list-datatable') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  CertificateFrames::getDataTable();
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'add') {
            $data = $this->add($data);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);
            if ($id) {
                $data = $this->view($data, $param2);
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);
            if ($id) {
                if (request()->method() == 'POST') {
                    return CertificateFrames::updateToTable($id);
                }
                $data = $this->edit($data, $param2);
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'delete') {
            return CertificateFrames::deleteFromTable($param2);
        } elseif ($param1 == 'make') {
            if (request()->method() == 'POST') {
                if (request()->all()) {
                    Session::put('certificate', json_decode(request("certificate"), true));
                    if (request()->hasFile('front_certificate')) {
                        $file = request()->front_certificate;
                        $file_tmp  = $file->getPathName();
                        $file_type = $file->getMimeType();
                        $file_str  = file_get_contents($file_tmp);
                        $tob64img  = base64_encode($file_str);
                        $certificate_front = 'data:' . $file_type . ';base64,' . $tob64img;
                        Session::put('certificate_front',  $certificate_front);
                    }

                    if (request()->hasFile('back_certificate')) {
                        $file = request()->back_certificate;
                        $file_tmp  = $file->getPathName();
                        $file_type = $file->getMimeType();
                        $file_str  = file_get_contents($file_tmp);
                        $tob64img  = base64_encode($file_str);
                        $certificate_back = 'data:' . $file_type . ';base64,' . $tob64img;
                        Session::put('certificate_back',  $certificate_back);
                    }

                    return array(
                        'success' => true,
                        'redirect' => str_replace('make', 'result', request()->getUri())
                    );
                }
            }
            $data = $this->make($data, $param3);
        } elseif ($param1 == 'set') {
            return $this->set($param2);
        } elseif ($param1 == 'result') {
            $d['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .Certificate.');
            MetaHelper::setConfig(
                [
                    'title'       => $d['title'],
                    'author'      => config('app.name'),
                    'keywords'    => null,
                    'description' => null,
                    'link'        => null,
                    'image'       => null
                ]
            );
            config()->set('app.title', $d['title']);
            $d['certificates'] = CertificateHelper::make($param3);
            return view('Certificate.includes.result.index', $d);
        } else {
            abort(404);
        }

        MetaHelper::setConfig([
            'title'       => $data['title'],
            'author'      => config('app.name'),
            'keywords'    => '',
            'description' => '',
            'link'        => null,
            'image'       => null
        ]);
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
            'parent'     => CertificateFrames::$path['view'],
            'view'       => $data['view'],
        );

        $pages['form']['validate'] = [
            'rules'       =>  FormCertificate::rulesField(),
            'attributes'  =>  FormCertificate::attributeField(),
            'messages'    =>  FormCertificate::customMessages(),
            'questions'   =>  FormCertificate::questionField(),
        ];


        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view(CertificateFrames::$path['view'] . '.index', $data);
    }

    public function list($data)
    {
        $data['view']     = CertificateFrames::$path['view'] . '.includes.list.index';
        $data['title']    = Translator::phrase(Users::role(app()->getLocale()) . '. | .list.Certificate');
        $data['response'] =  CertificateFrames::getData(null, null, 10);
        return $data;
    }

    public function add($data)
    {
        $data['view']  = CertificateFrames::$path['view'] . '.includes.form.index';
        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .add.Certificate');
        $data['metaImage'] = asset('assets/img/icons/register.png');
        $data['metaLink']  = url(Users::role() . '/add/');

        return $data;
    }

    public function view($data, $id)
    {
        $response = CertificateFrames::getData($id, true);
        $data['view']       = CertificateFrames::$path['view'] . '.includes.view.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .view.Certificate');
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/view/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/view/' . $response['data'][0]['id'];
        return $data;
    }

    public function edit($data, $id)
    {
        $response = CertificateFrames::getData($id, true);
        $data['view']       = CertificateFrames::$path['view'] . '.includes.form.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .edit.' . str_replace('-', '_', $data['formName']));
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/edit/' . $id);
        $data['formData']   = $response['data'][0];
        $data['listData']   = $response['pages']['listData'];
        $data['formAction'] = '/edit/' . $response['data'][0]['id'];
        return $data;
    }
    public function make($data, $user)
    {

        $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .Certificate.');
        $data['view']  = CertificateFrames::$path['view'] . '.includes.make.index';
        $data['certificates']['frame']  = CertificateFrames::getData(CertificateFrames::where('status', 1)->first()->id, 10)['data'][0];
        $data['certificates']['frame']['front'] = $data['certificates']['frame']['front_o'];
        $data['formName']   = Students::$path['url'] . '/' . StudentsStudyCourse::$path['url'] . '/' . CertificateFrames::$path['url'];
        $data['formAction'] = '/make/' . request('id');

        $data['certificates']['all'] = CertificateFrames::frameData('all');
        $data['certificates']['selected'] = CertificateFrames::frameData('selected');

        if ($user['success']) {
            $data['certificates']['user'] = $user['data'][0];
        } else {
            $data['certificates']['user'] =  [];
        }

        return $data;
    }

    public function set($id)
    {
        return CertificateFrames::setToTable($id);
    }
}
