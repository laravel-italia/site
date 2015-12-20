<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::controller('categories', 'CategoryController');
    Route::controller('articles', 'ArticleController');
    Route::controller('series', 'SeriesController');
    Route::controller('media', 'MediaController');
    Route::controller('/', 'MainController');
});

Route::get('auth', function (\LaravelItalia\Entities\Repositories\UserRepository $userRepository) {
    Auth::login(\LaravelItalia\Entities\User::first());

    return redirect('admin/dashboard');
});

/* Provisional Routes! */

Route::get('access-denied', function () {
    return 'Access Denied.';
});

Route::get('logout', function () {
    Auth::logout();

    return redirect('login');
});

Route::get('login', function () {
    return 'must login!';
});

Route::get('blank', function () {
    return view('admin.blank');
});
