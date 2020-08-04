<?php

namespace App\Models;

use App\Helpers\Encryption;
use App\Helpers\Translator;
use Illuminate\Support\Facades\Auth;
use PHPHtmlParser\Dom;

class MailboxSent
{
    public static $path = [
        'image'  => 'mail-box',
        'url'    => 'sent',
        'view'   => 'Mailbox'
    ];

    public static function getData($id = null, $type = 'list', $paginate = null, $search = null)
    {
        $pages = [];
        $get = Mailbox::where('from', Auth::user()->id)
                ->whereNotIn('id', MailboxTrash::select('mailbox_id')->where('user_id', Auth::user()->id)->get());

        $orderBy = 'DESC';
        if ($id) {
            $id  =  gettype($id) == 'array' ? $id : explode(',', Encryption::decode($id));
            $sorted = array_values($id);
            sort($sorted);
            if ($id === $sorted) {
                $orderBy = 'ASC';
            } else {
                $orderBy = 'DESC';
            }
        }
        if ($id) {
            $get = $get->whereIn((new Mailbox)->getTable() . '.id', $id);
        } else {
            if ($search) {
                $get = $get->where(function ($q) use ($search) {
                    $q->where('subject', 'LIKE', '%' . $search . '%');
                    $q->orWhere('message', 'LIKE', '%' . $search . '%');
                });
            }
        }


        $get = $get->orderBy((new Mailbox)->getTable() . '.id', $orderBy);

        if ($paginate) {
            $get = $get->paginate($paginate)->toArray();
            foreach ($get as $key => $value) {
                if ($key == 'data') {
                } else {
                    $pages[$key] = $value;
                }
            }

            $get = $get['data'];
        } else {
            $get = $get->get()->toArray();
        }

        if ($get) {
            $data = [];
            $dom = new Dom();
            foreach ($get as $key => $row) {
                $id = Encryption::encode($row['id']);
                $data[$key] = [
                    'id'        => $id,
                    'user'      => ($row['from'] == Auth::user()->id) ? Users::getData($row['recipient'])['data'][0] : Users::getData($row['from'])['data'][0],
                    'from'      => Users::getData($row['from'])['data'][0],
                    'recipient' => Users::getData($row['recipient'])['data'][0],
                    'subject' => $row['subject'],
                    'created_at' => $row['created_at'],
                    'action'    => [
                        'view'  => url(Mailbox::$path['url'] . '/' . MailboxSent::$path['url'] . '/view/' . $id),
                        'move_trash'  => url(Mailbox::$path['url'] . '/' . MailboxSent::$path['url'] . '/move-trash/' . $id),
                    ]
                ];

                if ($type == 'view') {
                    $data[$key]['message'] = $row['message'];
                    $dom->load($row['message']);
                    $data[$key]['attachment_images']  =  Mailbox::getAttachmentImages($dom->find('img'));
                }
            }
            $response = [
                'success'   => true,
                'data'   => $data,
                'pages' => $pages
            ];
        } else {
            $response = [
                'success'   => false,
                'data'   => [],
                'message'   => Translator::phrase('no_data'),
                'pages' => $pages
            ];
        }
        return $response;
    }
}
