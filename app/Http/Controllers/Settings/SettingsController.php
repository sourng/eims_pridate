<?php

namespace App\Http\Controllers\Settings;

use App\Models\App;
use App\Models\Roles;
use App\Models\Users;
use App\Models\Languages;
use App\Models\Sponsored;
use App\Models\Translates;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Helpers\Translator;
use App\Models\ThemesColor;
use App\Models\SocailsMedia;
use App\Models\FeatureSlider;
use App\Http\Requests\FormApp;
use App\Models\ThemeBackground;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Settings\RolesController;
use App\Http\Controllers\Settings\LanguagesController;
use App\Http\Controllers\Settings\SponsoredController;
use App\Http\Controllers\Settings\TranslateController;
use App\Http\Controllers\Settings\FeatureSliderController;

class SettingsController extends Controller
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
            'logo' => asset('/assets/img/icons/common/template-logo.png'),
            'favicon' => asset('/assets/img/icons/common/template-favicon.png'),
        );
        $data['formName'] = App::$path['url'];
        $data['formAction'] = '/add';
        $data['listData']       = array();
        if ($param1 == null) {
            $data['shortcut'] = [];

            if (Auth::user()->role_id == 1) {
                $data['shortcut'][] = [
                    'name'  => Translator::phrase('general'),
                    'link'  => url(Users::role() . '/' . App::$path['url'] . '/general'),
                    'icon'  => 'fas fa-sliders-h-square',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ];

                $data['shortcut'][] = [
                    'name'  => Translator::phrase('color'),
                    'link'  => url(Users::role() . '/' . App::$path['url'] . '/color'),
                    'icon'  => 'fas fa-palette',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ];

                $data['shortcut'][] = [
                    'name'  => Translator::phrase('theme_background'),
                    'link'  => url(Users::role() . '/' . App::$path['url'] . '/' . ThemeBackground::$path['url'] . '/list'),
                    'icon'  => 'fas fa-file-image',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ];

                $data['shortcut'][] = [
                    'name'  => Translator::phrase('sponsored'),
                    'link'  => url(Users::role() . '/' . App::$path['url'] . '/' . Sponsored::$path['url'] . '/list'),
                    'icon'  => 'fas fa-hands-usd',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ];
                $data['shortcut'][] = [
                    'name'  => Translator::phrase('language'),
                    'link'  => url(Users::role() . '/' . App::$path['url'] . '/' . Languages::$path['url'] . '/list'),
                    'icon'  => 'fas fa-flag',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ];

                $data['shortcut'][] = [
                    'name'  => Translator::phrase('translate'),
                    'link'  => url(Users::role() . '/' . App::$path['url'] . '/' . Translates::$path['url'] . '/list'),
                    'icon'  => 'fas fa-language',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ];
                $data['shortcut'][] = [
                    'name'  => Translator::phrase('clean'),
                    'link'  => url(Users::role() . '/' . App::$path['url'] . '/clean'),
                    'icon'  => 'fas fa-recycle',
                    'image' => null,
                    'color' => 'bg-' . config('app.theme_color.name'),
                ];
            }

            $data['shortcut'][] = [
                'name'  => Translator::phrase('feature'),
                'link'  => url(Users::role() . '/' . App::$path['url'] . '/' . FeatureSlider::$path['url'] . '/list'),
                'icon'  => 'fas fa-images',
                'image' => null,
                'color' => 'bg-' . config('app.theme_color.name'),
            ];

            $data['shortcut'][] = [
                'name'  => Translator::phrase('role'),
                'link'  => url(Users::role() . '/' . App::$path['url'] . '/' . Roles::$path['url'] . '/list'),
                'icon'  => 'fas fa-user-shield',
                'image' => null,
                'color' => 'bg-' . config('app.theme_color.name'),
            ];

            $data['view']  = App::$path['view'] . '.includes.dashboard.index';
            $data['title'] = Translator::phrase(Users::role(app()->getLocale()) . '. | .' . $data['formName']);
        } elseif ($param1 == 'list') {
            if (strtolower(request()->server('CONTENT_TYPE')) == 'application/json') {
                return  App::getData(null, null, 10);
            } else {
                $data = $this->list($data);
            }
        } elseif ($param1 == 'add') {

            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return App::addToTable();
                }
            }

            $data = $this->add($data);
        } elseif ($param1 == 'edit') {
            $id = request('id', $param2);
            if (request()->ajax()) {
                if (request()->method() === 'POST') {
                    return App::updateToTable($id);
                }
            }

            $data = $this->edit($data, $id);
        } elseif ($param1 == 'general') {
            if ($param2) {
                $id = $param2;
            } else {
                $id = request('id');
            }

            if (request()->method() == 'POST') {
                return App::updateToTable($param3);
            }
            $data = $this->general($data, $id);
        } elseif ($param1 == 'color') {

            if ($param2 == 'set' && request()->method() == 'POST') {
                return App::updateThemeColorToTable(config('app.id'), $param3);
            }

            $data = $this->color($data);
        } elseif ($param1 == Languages::$path['url']) {
            $view = new LanguagesController();
            return $view->index($param2, $param3);
        } elseif ($param1 == Translates::$path['url']) {
            $view = new TranslateController();
            return $view->index($param2, $param3);
        } elseif ($param1 == FeatureSlider::$path['url']) {
            $view = new FeatureSliderController();
            return $view->index($param2, $param3);
        } elseif ($param1 == Sponsored::$path['url']) {
            $view = new SponsoredController();
            return $view->index($param2, $param3);
        } elseif ($param1 == ThemeBackground::$path['url']) {
            $view = new ThemeBackgroundController();
            return $view->index($param2, $param3);
        } elseif ($param1 == Roles::$path['url']) {
            $view = new RolesController();
            return $view->index($param2, $param3);
        } elseif ($param1 == 'clean') {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            dd('cache config route view are clear.');
        } elseif ($param1 == 'delete') {

            $id = request('id', $param2);
            return App::deleteFromTable($id);
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
            'parent'     => App::$path['view'],
            'view'       => $data['view'],
        );

        $pages['form']['validate'] = [
            'rules'       =>  FormApp::rulesField(),
            'attributes'  =>  FormApp::attributeField(),
            'messages'    =>  FormApp::customMessages(),
            'questions'   =>  FormApp::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['response'] =  App::getData(null, null, 10);
        $data['view']     =  App::$path['view'] . '.includes.list.index';
        $data['title']    =  Translator::phrase(Users::role(app()->getLocale()) . '. | .list.' . str_replace('-', '_', $data['formName']));
        return $data;
    }


    public function general($data, $id)
    {
        $response           = App::getData($id, true);
        $data['view']       = App::$path['view'] . '.includes.general.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .view.' . str_replace('-', '_', $data['formName']));
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/view/');
        $data['formAction'] = '/general/add';
        if ($response['success']) {
            $data['formData']   = $response['data'][0];
            $data['listData']   = $response['pages']['listData'];
            $data['formAction'] = '/general/edit/' . $response['data'][0]['id'];
        }
        return $data;
    }
    public function color($data)
    {
        $data['response']   = ThemesColor::getData();
        $data['view']       = App::$path['view'] . '.includes.color.index';
        $data['title']      = Translator::phrase(Users::role(app()->getLocale()) . '. | .set.color');
        $data['metaImage']  = asset('assets/img/icons/register.png');
        $data['metaLink']   = url(Users::role() . '/view/');
        return $data;
    }
}
