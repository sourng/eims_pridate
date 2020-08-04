<?php

namespace App\Http\Controllers\Mailbox;


use App\Models\App;
use App\Models\Users;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\MetaHelper;
use App\Models\ThemesColor;
use App\Models\SocailsMedia;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormMailbox;
use App\Models\Mailbox;
use App\Models\MailboxImportant;
use App\Models\MailboxTrash;
use Illuminate\Support\Facades\Auth;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;


class MailboxTrashController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        App::setConfig();
        SocailsMedia::setConfig();
        Languages::setConfig();
    }


    public function index($param1 = 'inbox', $param2 = null, $param3 = null)
    {
        if (Auth::user()) {
            JavaScriptFacade::put([
                'User'  => [
                    'id'  => Auth::user()->id,
                    'name'  => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'profile'   => Auth::user()->profile(),
                ]
            ]);
        }
        $data['recipient'] =  Users::getData('null');
        $data['theme_color'] = ThemesColor::getData();
        $data['formName'] = '';
        $data['formAction'] = '/compose';
        $data['title'] = 'Mailbox';
        $data['listData']  = array();
        $data['inbox_count_unread'] = Mailbox::countUnread();
        $data['important_count'] = MailboxImportant::count();
        $data['trash_count'] = MailboxTrash::count();
        $data['formData'] = [];

        if ($param1 == null) {
            $data = $this->list($data);
        } elseif ($param1 == 'view') {
            $id = request('id', $param2);
            $data['response'] =  MailboxTrash::getData($id, $param1);
            $data['view']      = Mailbox::$path['view'] . '.includes.view.index';
        } elseif ($param1 == 'delete') {
            $id = request('id', $param2);
            return MailboxTrash::deleteFromTable($id, Auth::user()->id);
        } elseif ($param1 == 'move-inbox') {
            $id = request('id', $param2);
            return MailboxTrash::deleteFromTable($id, Auth::user()->id);
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
            'form'       => FormHelper::form($data['formData'], $data['formName'], $data['formAction'], Mailbox::$path['url']),
            'parent'     => Mailbox::$path['view'],
            'view'       => $data['view'],
        );
        $pages['form']['validate'] = [
            'rules'       =>  FormMailbox::rulesField(),
            'attributes'  =>  FormMailbox::attributeField(),
            'messages'    =>  FormMailbox::customMessages(),
            'questions'   =>  FormMailbox::questionField(),
        ];

        config()->set('app.title', $data['title']);
        config()->set('pages', $pages);
        return view($pages['parent'] . '.index', $data);
    }

    public function list($data)
    {
        $data['response'] =  MailboxTrash::getData(null, 'list', 10, request('search'));
        $data['view']      = Mailbox::$path['view'] . '.includes.trash.index';
        return $data;
    }
}
