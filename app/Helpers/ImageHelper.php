<?php

namespace App\Helpers;

use DomainException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{

    public static $path = [
        'image'     =>  'images',
        'resize'    =>  ['small', 'large'],
        'mime'      => [
            'image/png',
            'image/x-png',
            'image/jpg',
            'image/jpeg',
            'image/pjpeg',
            'image/gif',
            'image/webp',
            'image/x-webp',
        ],
    ];
    /**
     * @return asset('/assets/img/icons/image.jpg');
     */
    public static function prefix()
    {
        return asset('/assets/img/icons/image.jpg');
    }

    public static function uploadImage($photo, $destination, $rename = null, $file = null, $slide = null, $resize = true)
    {
        ini_set('memory_limit', '1G');

        $folder = 'public/' . ImageHelper::$path['image'] . '/' . $destination;
        Storage::makeDirectory($folder);

        $destinationPath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $folder;
        $newFilenameNoExtension =  ImageHelper::num_random(8) . '_' . ImageHelper::num_random(15) . '_' . ImageHelper::num_random(19) . '_n.';
        $imageEx  = pathinfo($file, PATHINFO_EXTENSION);
        $name  =  $rename ? ($rename . '.' . pathinfo($file, PATHINFO_EXTENSION)) : ($newFilenameNoExtension . pathinfo($file, PATHINFO_EXTENSION));

        Storage::makeDirectory($folder . '/original');
        $destinationPath .= '/original';

        if ($photo) {
            $getMimeType = explode('/', $photo->getMimeType());
            $imageEx    = $photo->getClientOriginalExtension() ? $photo->getClientOriginalExtension() : end($getMimeType);
            $name       =  $rename ? ($rename . '.' . $imageEx) : ($newFilenameNoExtension . $imageEx);
            $name       = strtolower($name);


            if ($photo->move($destinationPath, $name)) {
                if (in_array(File::mimeType($destinationPath . '/' . $name), ImageHelper::$path['mime'])) {
                    $image = Image::make($destinationPath . '/' . $name);
                    $image->widen($image->width(), function ($constraint) {
                        $constraint->upsize();
                    })->save(null, 50);
                }
            }
        } else {
            if ($file && file_exists($file)) {
                File::copy($file,  $destinationPath . '/' . $name);
            } elseif ($file && preg_match('/data:image/i', $file) && preg_match('/base64/i', $file)) {
                $getMimeType = explode('/', explode(';', $file)[0]);
                $name   .= end($getMimeType);
                Image::make(file_get_contents($file))->save($destinationPath . '/' . $name);
            }
        }

        if ($resize) {
            foreach (ImageHelper::$path['resize'] as $size) {
                $folderSize = 'public/' . ImageHelper::$path['image'] . '/' . $destination . '/' . $size;
                Storage::makeDirectory($folderSize);
                $fileInFolderSize = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $folderSize . '/' . $name;
                if (!file_exists($fileInFolderSize)) {
                    File::copy($destinationPath . '/' . $name, $fileInFolderSize);
                    if ($size == 'small') {
                        try {
                            Image::make($fileInFolderSize)->fit(120, 120, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(null, 100);
                        } catch (DomainException $e) {
                            return $e;
                        }
                    } elseif ($size == 'large') {
                        try {
                            Image::make($fileInFolderSize)->fit(480, 480, function ($constraint) {
                                $constraint->aspectRatio();
                            })->save(null, 100);
                        } catch (DomainException $e) {
                            return $e;
                        }
                    }
                }
            }
        }

        if ($slide) {
            $folderSize = 'public/' . ImageHelper::$path['image'] . '/' . $destination . '/slide';
            Storage::makeDirectory($folderSize);
            $fileInFolderSize = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $folderSize . '/' . $name;
            if (!file_exists($fileInFolderSize)) {
                File::copy($destinationPath . '/' . $name, $fileInFolderSize);
                Image::make($fileInFolderSize)->fit(1000, 400, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(null, 100);
            }
        }
        return $name;
    }
    public static function getImage($filename, $path, $type = null, $width = null, $height = null, $quality = null)
    {


        if ($type) {
            $folderSize = 'public/' . ImageHelper::$path['image'] . '/' . $path . '/' . $type;
        } else {
            $folderSize = 'public/' . ImageHelper::$path['image'] . '/' . $path . '/small';
        }



        $dir = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $folderSize;
        $file = $dir . '/' . $filename;
        $response = [
            'success' => false,
            'error'   => '?type=[small, large, original]'
        ];
        if (File::exists($file)) {
            if (in_array(File::mimeType($file), ImageHelper::$path['mime'])) {
                $response = Image::make($file)->response(null, $quality);
            }
        } else {
            $response = [
                'success' => false,
                'error'   => 'File not found.'
            ];
        }
        return $response;
    }
    public static function getImageNoType($filename, $path, $encode = null)
    {
        if ($filename && $path) {
            $dir = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'public/' . (ImageHelper::$path['image'] . '/' . $path);

            $file = $dir . '/' . $filename;
            if ($encode) {
                $response = (string) Image::make($file)->encode('data-url');
            } else {
                $response = Image::make($file)->response();
            }
            return $response;
        }

        return null;
    }
    public static function site($path, $filename, $type = null, $width = null, $height = null, $quality = null)
    {


        if ($path && $filename) {
            $uurl = url(ImageHelper::$path['image'] . '/' . $path . '/' . $filename);

            if ($type) {
                $uurl .= '?type=' . $type;
            } else {
                if ($width) {
                    $uurl .= '?w=' . $width;
                }
                if ($height) {
                    if ($width) {
                        $uurl .= '&h=' . $height;
                    } else {
                        $uurl .= '?h=' . $height;
                    }
                }
                if ($quality) {
                    if ($height) {
                        $uurl .= '&q=' . $quality;
                    } else {
                        $uurl .= '?q=' . $quality;
                    }
                }
            }
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
