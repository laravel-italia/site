<?php

namespace LaravelItalia\Http\Controllers\Admin;

use Illuminate\Http\Request;

use LaravelItalia\Http\Requests;
use LaravelItalia\Http\Controllers\Controller;

class MainController extends Controller
{
    public function getDashboard()
    {
        return view('admin.dashboard');
    }
}
