<?php

namespace App\Helpers;

class Internet
{
    public static  function conneted($w = 'www.google.com')
    {  
        return @fsockopen($w,80);
    }
}
