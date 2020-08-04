<?php

namespace App\Http\Controllers\General;

use App\Models\App;
use App\Models\Days;
use App\Models\Users;
use App\Models\Years;
use App\Models\Gender;
use App\Models\Months;
use App\Models\Marital;
use App\Models\Communes;
use App\Models\Holidays;
use App\Models\Villages;
use App\Models\Districts;
use App\Models\Languages;
use App\Models\Provinces;
use App\Models\BloodGroup;
use App\Models\MotherTong;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\Nationality;
use App\Models\SocailsMedia;
use App\Http\Controllers\Controller;
use App\Http\Controllers\General\DayController;
use App\Http\Controllers\General\MonthController;
use App\Http\Controllers\General\GenderController;
use App\Http\Controllers\General\CommuneController;
use App\Http\Controllers\General\HolidayController;
use App\Http\Controllers\General\MaritalController;
use App\Http\Controllers\General\VillageController;
use App\Http\Controllers\General\DistrictController;
use App\Http\Controllers\General\ProvinceController;
use App\Http\Controllers\General\BloodGroupController;
use App\Http\Controllers\General\MotherTongController;
use App\Http\Controllers\General\NationalityController;


class GeneralController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }


    public function index($param1 = null, $param2 = null, $param3 = null)
    {
        $data['formData'] = array(
            'image' => asset('/assets/img/icons/image.jpg'),
        );
        $data['formName']       = 'general';
        $data['formAction']     = '/add';
        $data['listData']       = array();
        if ($param1 == null || $param1 == 'list') {
            $data['shortcut'] = array(
                [
                    'name'  => Translator::phrase('list.province'),
                    'link'  => url(Users::role() . '/general/' . Provinces::$path['url'] . '/list'),
                    'icon'  => null,
                    'text'  => Translator::phrase('province'),
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.district'),
                    'link'  => url(Users::role() . '/general/' . Districts::$path['url'] . '/list'),
                    'icon'  => null,
                    'text'  => Translator::phrase('district'),
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.commune'),
                    'link'  => url(Users::role() . '/general/' . Communes::$path['url'] . '/list'),
                    'icon'  => null,
                    'text'  => Translator::phrase('commune'),
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.village'),
                    'link'  => url(Users::role() . '/general/' . Villages::$path['url'] . '/list'),
                    'icon'  => null,
                    'text'  => Translator::phrase('village'),
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.nationality'),
                    'link'  => url(Users::role() . '/general/' . Nationality::$path['url'] . '/list'),
                    'icon'  => 'fas fa-flag',
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.mother_tong'),
                    'link'  => url(Users::role() . '/general/' . MotherTong::$path['url'] . '/list'),
                    'icon'  => 'fas fa-head-side-headphones',
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.gender'),
                    'link'  => url(Users::role() . '/general/' . Gender::$path['url'] . '/list'),
                    'icon'  => 'fas fa-venus-mars',
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.marital'),
                    'link'  => url(Users::role() . '/general/' . Marital::$path['url'] . '/list'),
                    'icon'  => 'fas fa-rings-wedding',
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.blood_group'),
                    'link'  => url(Users::role() . '/general/' . BloodGroup::$path['url'] . '/list'),
                    'icon'  => 'fas fa-hand-holding-water',
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('year')  .' '.Years::now(),
                    'link'  => '#',
                    'icon'  => null,
                    'text'  => Years::now(),
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.month'),
                    'link'  => url(Users::role() . '/general/' . Months::$path['url'] . '/list'),
                    'icon'  => null,
                    'text'  => Translator::phrase('month'),
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.day'),
                    'link'  => url(Users::role() . '/general/' . Days::$path['url'] . '/list'),
                    'icon'  => null,
                    'text'  => Translator::phrase('day'),
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ], [
                    'name'  => Translator::phrase('list.holiday'),
                    'link'  => url(Users::role() . '/general/' . Holidays::$path['url'] . '/list'),
                    'icon'  => null,
                    'text'  => Translator::phrase('holiday'),
                    'image' => null,
                    'color' => 'bg-'.config('app.theme_color.name'),
                ],
            );
            $data['view']  = 'General.includes.dashboard.index';
            $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        } elseif (strtolower($param1) == Provinces::$path['url']) {
            $view = new ProvinceController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == Districts::$path['url']) {
            $view = new DistrictController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == Communes::$path['url']) {
            $view = new CommuneController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == Villages::$path['url']) {
            $view = new VillageController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == Nationality::$path['url']) {
            $view = new NationalityController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == MotherTong::$path['url']) {
            $view = new MotherTongController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == Gender::$path['url']) {
            $view = new GenderController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == Marital::$path['url']) {
            $view = new MaritalController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == BloodGroup::$path['url']) {
            $view = new BloodGroupController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == Months::$path['url']) {
            $view = new MonthController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == Days::$path['url']) {
            $view = new DayController();
            return $view->index($param2,$param3);
        } elseif (strtolower($param1) == Holidays::$path['url']) {
            $view = new HolidayController();
            return $view->index($param2,$param3);
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
            'parent'     => 'General',
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  [],
            'attributes'  =>  [],
            'messages'    =>  [],
            'questions'   =>  [],
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }
}
