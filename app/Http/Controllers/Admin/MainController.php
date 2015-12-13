<?php

namespace LaravelItalia\Http\Controllers\Admin;

use LaravelItalia\Http\Controllers\Controller;

class MainController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:editor,administrator');
    }

    public function getDashboard()
    {
        return view('admin.dashboard');
    }
}
