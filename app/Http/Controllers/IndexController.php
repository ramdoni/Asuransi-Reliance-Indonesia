<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function backtoadmin()
    {
        if(\Session::get('is_login_administrator'))
        {
            \Auth::loginUsingId(\Session::get('is_id'));

            return redirect('/')->with('message-success', 'Welcome Back Administrator');
        }
    }
}
