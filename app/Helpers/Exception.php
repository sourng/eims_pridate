<?php

namespace App\Helpers;


use App\Helpers\Translator;

class Exception
{
    public static function exception(\DomainException $e)
    {
        $code    = $e->getCode();
        $message = $e->getMessage();
        $error   = isset($e->errorInfo[2]) ? $e->errorInfo[2] : [];

        if ($code === '42S22') {
            $s = stripos($message, 'SQL:');
            $message = substr($message, $s);
            $error   = str_replace(
                'Unknown column',
                Translator::phrase('unknown_column'),
                $error
            );
            $error  = str_replace(
                'in',
                Translator::phrase('in'),
                $error
            );
            $error  = str_replace(
                'where clause',
                Translator::phrase('where_clause'),
                $error
            );

            $error  = str_replace(
                'field list',
                Translator::phrase('field_list'),
                $error
            );
        }

        $response = response(
            array(
                "success"   => false,
                "message"   => array(
                    'title' => Translator::phrase('error'),
                    'text'  => $message,
                    'button'   => array(
                        'confirm' => Translator::phrase('ok'),
                        'cancel'  => Translator::phrase('cancel'),
                    ),
                ),
                'code'     => $e->getCode(),
                "errors"    => $error,
            ),
            500
        );
        return $response;
    }
}
