<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct()
    {
        
     }

    public function index()
    {
        return $this->dashboard();
    }

    public function dashboard()
    {

        echo 'Account';
    } // End dashboard
}
