<?php

namespace App\Models;

use App\Helpers\Encryption;
use App\Helpers\Translator;
use Illuminate\Database\Eloquent\Model;

class MailboxRead extends Model
{
    public static $path = [
        'url'    => 'mark-read',
        'view'   => 'Mailbox'
    ];

    public static function addToTable($mailbox_id, $user_id)
    {
        if ($mailbox_id && $user_id) {
            $mailbox_id = gettype($mailbox_id) == 'array' ? $mailbox_id : explode(',', $mailbox_id);
            foreach ($mailbox_id as $value) {
                $mid = Encryption::decode($value);
                $exists = MailboxRead::existsFromTable($mid, $user_id);

                if ($exists) {
                    $response = [
                        'success'   => false,
                        'message'   => Translator::phrase('already_exists')
                    ];
                } else {
                    $add = MailboxRead::insert([
                        'mailbox_id'    => $mid,
                        'user_id'       => $user_id
                    ]);

                    if ($add) {
                        $response = [
                            'success'   => true,
                            'type'      => 'mark-read',
                            'message'   => array(
                                'title' => Translator::phrase('success'),
                                'text'  => Translator::phrase('mark_read.successfully'),
                                'button'   => array(
                                    'confirm' => Translator::phrase('ok'),
                                    'cancel'  => Translator::phrase('cancel'),
                                ),
                            ),
                        ];
                    }
                }
                return $response;
            }
        }
    }

    public static function existsFromTable($mailbox_id, $user_id)
    {
        return MailboxRead::where('mailbox_id', $mailbox_id)->where('user_id', $user_id)->first();
    }
}
