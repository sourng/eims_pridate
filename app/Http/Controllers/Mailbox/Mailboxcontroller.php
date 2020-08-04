<?php

namespace App\Http\Controllers\Mailbox;


use App\Models\App;
use App\Models\Users;
use App\Models\Languages;
use App\Helpers\FormHelper;
use App\Helpers\ImageHelper;
use App\Helpers\MetaHelper;
use App\Models\ThemesColor;
use App\Models\SocailsMedia;
use App\Http\Controllers\Controller;
use App\Http\Requests\FormMailbox;
use App\Models\Mailbox;
use App\Models\MailboxImportant;
use App\Models\MailboxRead;
use App\Models\MailboxReply;
use App\Models\MailboxSent;
use App\Models\MailboxTrash;
use Illuminate\Support\Facades\Auth;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;


class MailboxController extends Controller
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
        $data['listData']       = array();
        $data['inbox_count_unread'] = Mailbox::countUnread();
        $data['important_count'] = MailboxImportant::count();
        $data['trash_count'] = MailboxTrash::count();
        $data['formData'] = [];

        if ($param1 == 'compose') {
            if (request()->method() == 'POST') {
                return Mailbox::addToTable();
            }
            $data['view']      = Mailbox::$path['view'] . '.includes.form.index';
        } elseif ($param1 == 'upload') {
            if (request()->method() == 'POST' && request()->hasFile('image')) {
                $image = ImageHelper::uploadImage(request()->file('image'), Mailbox::$path['image']);
                if ($image) {
                    return [
                        'success' => true,
                        'data'  => [ImageHelper::site(Mailbox::$path['image'], $image,'original')]
                    ];
                }
            }
            return [
                'success' => false,
                'data'  => []
            ];
        } elseif ($param1 == 'reply') {
            if (request()->method() == 'POST') {
                return MailboxReply::addToTable();
            }
        } elseif ($param1 == 'inbox') {
            $id = request('id', $param3);
            if ($param2 == 'view') {
                $data['response'] =  Mailbox::getData($id, $param2);
                $data['view']      = Mailbox::$path['view'] . '.includes.view.index';
            } elseif ($param2 == 'move-trash') {
                return MailboxTrash::addToTable($id, Auth::user()->id);
            } else {
                $data['response'] =  Mailbox::getData($id, 'list', 10);
                $data['view']      = Mailbox::$path['view'] . '.includes.inbox.index';
            }
        } elseif ($param1 == 'sent') {
            $id = request('id', $param3);
            if ($param2 == 'view') {
                $data['response'] =  MailboxSent::getData($id, $param2);
                $data['view']      = Mailbox::$path['view'] . '.includes.view.index';
            } elseif ($param2 == 'move-trash') {
                return MailboxTrash::addToTable($id, Auth::user()->id);
            } else {
                $data['response'] =  MailboxSent::getData($id, 'list', 10);
                $data['view']      = Mailbox::$path['view'] . '.includes.sent.index';
            }
        } elseif ($param1 == MailboxImportant::$path['url']) {
            $view = new MailboxImportantController;
            return $view->index($param2, $param3);
        } elseif ($param1 == MailboxTrash::$path['url']) {
            $view = new MailboxTrashController;
            return $view->index($param2, $param3);
        } elseif ($param1 == 'move-trash') {
            $id = request('id', $param2);
            return MailboxTrash::addToTable($id, Auth::user()->id);
        } elseif ($param1 == 'mark-read') {
            $id = request('id', $param2);
            return MailboxRead::addToTable($id, Auth::user()->id);
        } elseif ($param1 == 'mark-important') {
            $id = request('id', $param2);
            return MailboxImportant::addToTable($id, Auth::user()->id);
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
}
