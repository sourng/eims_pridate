<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LibraryController extends Controller
{
    public function __construct()
    { }

    public function index()
    {
        return $this->dashboard();
    }

    public function dashboard()
    {

        echo 'Library';
    } // End dashboard
}
