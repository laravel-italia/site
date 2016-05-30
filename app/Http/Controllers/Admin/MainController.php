<?php

namespace LaravelItalia\Http\Controllers\Admin;

use \Auth;
use Illuminate\Support\Collection;
use LaravelItalia\Http\Controllers\Controller;
use LaravelItalia\Http\Requests\UserLoginRequest;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getLogin', 'postLogin']]);
        $this->middleware('role:editor,administrator', ['except' => ['getLogin', 'postLogin']]);
    }

    public function getIndex()
    {
        return redirect('admin/dashboard');
    }

    public function getDashboard()
    {
        return view('admin.dashboard');
    }

    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(UserLoginRequest $request)
    {
        if(Auth::attempt($request->except('_token'), true)) {
            return redirect('admin/dashboard');
        } else {
            return redirect('admin/login')->with('errors', Collection::make(['Credenziali non corrette. Riprovare.']));
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect('admin/login')->with('message', 'Logout effettuato. A presto!');
    }
}
