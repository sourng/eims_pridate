<?php

namespace App\Http\Controllers\Uasges;

use Highlight\Highlighter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UasgesController extends Controller
{
    public function index($usage)
    {
        $response = array();
        if ($usage) {
            if (!file_exists(public_path('usages/' . $usage))) {

                echo '<link href="' . asset('/styles/vs.css') . '" rel="stylesheet" />';

                $hl = new Highlighter();
                $hl->setAutodetectLanguages(array('ruby', 'python', 'perl', 'php'));

                $code = file_get_contents(public_path('uasges/' . $usage . '.php'));

                try {
                    // Highlight some code.
                    $highlighted = $hl->highlight('php', $code);
                    $usage  =  "<pre><code class=\"hljs {$highlighted->language}\">";
                    $usage .= $highlighted->value;
                    $usage .= "</code></pre>";
                } catch (DomainException $e) {
                    // This is thrown if the specified language does not exist
                    $usage = "<pre><code>";
                    $usage .= $code;
                    $usage .= "</code></pre>";
                }
            }

            $response = $usage;
        }


        // $files = \File::files(public_path('styles'));
        // foreach($files as $f){
        //     if(ends_with($f, ['.css'])){
        //         $name = $f->getRelativePathname();
        //         echo '<link href="'.asset('/styles/'.$name).'" rel="stylesheet" />';
        //         echo $response;
        //     }
        // }
        return  $response;
    }
}
