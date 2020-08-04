<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class VideoHelper
{

    public static $path = [
        'video'  =>  'videos',
        'resize'  =>  [120, 240, 480],
    ];

    public static function uploadVideo($video, $destination, $rename = null)
    {
        $folder = 'public/'.VideoHelper::$path['video'] . '/' . $destination;
        Storage::makeDirectory($folder);
        $destinationPath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $folder;
        $newFilenameNoExtension =  VideoHelper::num_random(8) . '_' . VideoHelper::num_random(15) . '_' . VideoHelper::num_random(19) . '_n.';

        if ($video) {
            $getMimeType = explode('/', $video->getMimeType());
            $imageEx    = $video->getClientOriginalExtension() ? $video->getClientOriginalExtension() : end($getMimeType);
            if ($imageEx != 'mp4') {
                $imageEx = 'mp4';
            }
            $name       =  $rename ? ($rename . '.' . $imageEx) : ($newFilenameNoExtension . $imageEx);
            if ($video->move($destinationPath, $name)) {
            }
            return $name;
        }
    }

    public static function getVideo($filename, $path, $encode = null, $type = null, $width = null, $height = null, $quality = null)
    {

        if ($quality) {
            $quality = $quality > 100 ? 100 : $quality;
        }

        if ($filename && $path) {

            $dir = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() .'public/'. (VideoHelper::$path['video'] . '/' . $path);

            $file = $dir . '/' . $filename;
            if (File::exists($file)) {
               // return Storage::disk('local')->get(VideoHelper::$path['video'] . '/' . $path.'/'.$filename);
                $headers = [
                    'Accept-Ranges'  => 'bytes',
                    'Content-Type'   => File::mimeType($file),
                    'Content-Length' => File::size($file),
                    'Content-Disposition' => 'inline; filename=' . $filename
                ];

                return response()->stream(function () use ($file) {
                    try {
                        $stream = fopen($file, 'r');
                        fpassthru($stream);
                    } catch (Exception $e) {
                        Log::error($e);
                    }
                }, 200, $headers);
            }
            return array(
                'success' => false,
                'message'  => 'Bad URL timestamp'
            );
        }
    }

    public static function site($path, $filename, $type = null, $width = null, $height = null, $quality = null)
    {
        if ($path && $filename) {
            $uurl = Storage::url(VideoHelper::$path['video'] . '/' . $path . '/' . $filename);

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
