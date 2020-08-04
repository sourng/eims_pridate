<?php

namespace App\Models;

use DomainException;
use App\Helpers\Encryption;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use PHPHtmlParser\Dom;

class MailboxTrash extends Model
{
    public static $path = [
        'url'    => 'trash',
        'view'   => 'Mailbox'
    ];

    public static function getData($id = null, $type = 'list', $paginate = null, $search = null)
    {
        $pages = [];
        $get = MailboxTrash::select((new Mailbox)->getTable() . '.*')
            ->join((new Mailbox)->getTable(), (new Mailbox)->getTable() . '.id', (new MailboxTrash())->getTable() . '.mailbox_id')
            ->where('user_id', Auth::user()->id);

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
                        'view'  => url(Mailbox::$path['url'] . '/' . MailboxTrash::$path['url'] . '/view/' . $id),
                        'move_inbox'  => url(Mailbox::$path['url'] . '/' . MailboxTrash::$path['url'] . '/move-inbox/' . $id),
                        'delete'  => url(Mailbox::$path['url'] . '/' . MailboxTrash::$path['url'] . '/delete/' . $id),
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


    public static function addToTable($mailbox_encode_id, $user_id)
    {
        if ($mailbox_encode_id) {
            $id  = gettype($mailbox_encode_id) == 'array' ? $mailbox_encode_id : explode(',', $mailbox_encode_id);
            $mailbox = [];
            foreach ($id as $value) {
                $mailbox[] = [
                    'mailbox_id' => Encryption::decode($value),
                    'user_id' => $user_id,
                ];
            }
            if (request()->method() === 'POST') {
                $add = MailboxTrash::insert($mailbox);
                if ($add) {
                    $response       =  array(
                        'success'   => true,
                        'message'   => array(
                            'title' => Translator::phrase('move_trash.!'),
                            'text'  => Translator::phrase('move_trash.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                }
            } else {
                $response = response(
                    array(
                        'success'   => true,
                        'message'   => array(
                            'title' => Translator::phrase('are_you_sure.?'),
                            'text'  => Translator::phrase('move_trash.!') . PHP_EOL .
                                'ID : (' . implode(',', $id) . ')',
                            'button'   => array(
                                'confirm' => Translator::phrase('yes'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    )
                );
            }
        }
        return $response;
    }
    public static function count()
    {
        return MailboxTrash::where('user_id', Auth::user()->id)->count();
    }
    public static function deleteFromTable($mailbox_encode_id, $user_id)
    {
        if ($mailbox_encode_id) {
            $id  = gettype($mailbox_encode_id) == 'array' ? $mailbox_encode_id : explode(',', $mailbox_encode_id);
            $mailbox = [];
            foreach ($id as $value) {
                $mailbox[] = Encryption::decode($value);
            }
            if (request()->method() === 'POST') {
                $delete = MailboxTrash::where('user_id', $user_id)
                    ->whereIn('mailbox_id', $mailbox)
                    ->delete();
                if ($delete) {
                    $response       =  array(
                        'success'   => true,
                        'message'   => array(
                            'title' => Translator::phrase('restore.!'),
                            'text'  => Translator::phrase('restore.successfully'),
                            'button'   => array(
                                'confirm' => Translator::phrase('ok'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    );
                }
            } else {
                $response = response(
                    array(
                        'success'   => true,
                        'message'   => array(
                            'title' => Translator::phrase('are_you_sure.?'),
                            'text'  => Translator::phrase('restore_mailbox.!') . PHP_EOL .
                                'ID : (' . implode(',', $id) . ')',
                            'button'   => array(
                                'confirm' => Translator::phrase('yes'),
                                'cancel'  => Translator::phrase('cancel'),
                            ),
                        ),
                    )
                );
            }
        }
        return $response;
    }
}
