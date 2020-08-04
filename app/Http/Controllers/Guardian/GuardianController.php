<?php

namespace App\Http\Controllers\Guardian;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuardianController extends Controller
{
    public function __construct()
    { }

    public function index()
    {
        return $this->dashboard();
    }

    public function dashboard()
    {

        echo 'Guardian';
    } // End dashboard
}
