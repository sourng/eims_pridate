<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RenatoMarinho\LaravelPageSpeed\Middleware\LazyLoadImages;

class FileHelper
{

    public static $path = [
        'file'  =>  'file',
    ];

    public static function uploadFile($file, $destination, $rename = null)
    {
        $folder = 'public/' . FileHelper::$path['file'] . '/' . $destination;
        Storage::makeDirectory($folder);
        $destinationPath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $folder;
        $newFilenameNoExtension =  FileHelper::num_random(8) . '_' . FileHelper::num_random(15) . '_' . FileHelper::num_random(19) . '_n.';

        if ($file) {
            $getMimeType = explode('/', $file->getMimeType());
            $imageEx    = $file->getClientOriginalExtension() ? $file->getClientOriginalExtension() : end($getMimeType);
            $name       =  $rename ? ($rename . '.' . $imageEx) : ($newFilenameNoExtension . $imageEx);
            $name       = strtolower($name);
            if ($file->move($destinationPath, $name)) {
            }
            return $name;
        }
    }
    public static function getFileInfo($path, $filename)
    {

        if ($filename && $path) {
            $dir = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'public/' . (FileHelper::$path['file'] . '/' . $path);

            $file = $dir . '/' . $filename;

            if (File::exists($file)) {
                return [
                    'name' => File::name($file),
                    'mime_type' => File::mimeType($file),
                    'extension' => File::extension($file),
                    'size'      => File::size($file),
                ];
            }
        }
    }
    public static function site($path, $filename)
    {
        if ($path && $filename) {
            $uurl = Storage::url(FileHelper::$path['file'] . '/' . $path . '/' . $filename);
            return $uurl;
        }
        return null;
    }

    public static function num_random($length = 10)
    {
        $chars = '0123456789011121314151617181920';
        $str = '';
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }
}
