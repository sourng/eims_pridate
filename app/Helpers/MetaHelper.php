<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;


class MetaHelper
{
    public static function setConfig(array $arrayObject)
    {
        Config::set("app.meta", MetaHelper::all($arrayObject));
        Config::set("app.meta_html", MetaHelper::html($arrayObject));
    }

    /**
     * @param array $arrayObject
     *
     * title => string
     *
     * author => string
     *
     * keywords => string
     *
     * description => string
     *
     * link  => string url
     *
     * image  => string url
     *
     * @return array
     */
    public static function all(array $arrayObject)
    {
        return  [
            "simple"   => MetaHelper::simple($arrayObject),
            "twitter"   => MetaHelper::twitter($arrayObject),
            "graph-data"   => MetaHelper::graphData($arrayObject),
            "google+"   => MetaHelper::googlePlus($arrayObject),
        ];
    }

    public static function html(array $arrayObject)
    {
        $metas =  [
            "simple"   => MetaHelper::simple($arrayObject),
            "twitter"   => MetaHelper::twitter($arrayObject),
            "graph-data"   => MetaHelper::graphData($arrayObject),
            "google+"   => MetaHelper::googlePlus($arrayObject),
        ];

        $html = "";
        foreach ($metas as $keys) {
            for ($i = 0; $i < count($keys); $i++) {
                $meta = array();
                foreach ($keys[$i] as $name => $item) {
                    $meta[] = $name;
                }

                if (count($meta) == 1) {
                    $html .= "<meta {$meta[0]}=\"{$keys[$i][$meta[0]]}\"/>\n";
                } else {
                    $html .= "<meta {$meta[0]}=\"{$keys[$i][$meta[0]]}\" {$meta[1]}=\"{$keys[$i][$meta[1]]}\"/>\n";
                }
            }
        }
        return $html;
    }




    /**
     * @param array $arrayObject
     *
     * author => string
     *
     * keywords => string
     *
     * description => string
     *
     * @return array
     */

    public static function simple(array $arrayObject)
    {
        return [
            [
                "charset"  => "utf-8"
            ],
            [
                "name" => "csrf-token",
                "content" => csrf_token(),
            ],
            [
                "http-equiv"  => "content-type",
                "content"  => "text/html;charset=utf-8",
            ],
            [
                "name"  => "viewport",
                "content"  => "width=device-width, initial-scale=1, shrink-to-fit=no",
            ],
            [
                "name"  => "author",
                "content"  => $arrayObject["author"],
            ],
            [
                "name"  => "keywords",
                "content"  => $arrayObject["keywords"],
            ],
            [
                "name"  => "description",
                "content"  => $arrayObject["description"],
            ],
        ];
    }




    /**
     * @param array $arrayObject
     *
     * title => string
     *
     * author => string
     *
     * description => string
     *
     * link  => string url
     *
     * image  => string url
     *
     * @return array
     */
    public static function twitter(array $arrayObject)
    {
        return [
            [
                "name"  => "twitter:card",
                "content"  => "twitter:card",
            ],
            [
                "name"  => "twitter:site",
                "content"  => $arrayObject["link"],
            ],
            [
                "name"  => "twitter:title",
                "content"  => $arrayObject["title"],
            ],
            [
                "name"  => "twitter:description",
                "content"  => $arrayObject["description"],
            ],
            [
                "name"  => "twitter:creator",
                "content"  => $arrayObject["author"],
            ],
            [
                "name"  => "twitter:image",
                "content"  =>  $arrayObject["image"],
            ],
        ];
    }

    /**
     * @param array $arrayObject
     *
     * title => string
     *
     * author => string
     *
     * description => string
     *
     * link  => string url
     *
     * image  => string url
     *
     * @return array
     */
    public static function graphData(array $arrayObject)
    {
        return [
            [
                "property"  => "fb:app_id",
                "content"  => "",
            ],
            [
                "property"  => "og:title",
                "content"  => $arrayObject["title"],
            ],
            [
                "property"  => "og:type",
                "content"  => "",
            ],
            [
                "property"  => "og:url",
                "content"  => $arrayObject["link"],
            ],
            [
                "property"  => "og:image",
                "content"  => $arrayObject["image"],
            ],
            [
                "property"  => "og:description",
                "content"  => $arrayObject["description"],
            ],
            [
                "property"  => "og:site_name",
                "content"  => $arrayObject["title"],
            ],
        ];
    }

    /**
     * @param array $arrayObject
     *
     * title => string
     *
     * description => string
     *
     * image  => string url
     *
     * @return array
     */
    public static function googlePlus(array $arrayObject)
    {
        return [
            [
                "itemprop"  => "name",
                "content"  => $arrayObject["title"],
            ],
            [
                "itemprop"  => "description",
                "content"  => $arrayObject["description"],
            ],
            [
                "itemprop"  => "image",
                "content"  => $arrayObject["image"],
            ],
        ];
    }
}
