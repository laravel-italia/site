<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::controller('categories', 'CategoryController');
    Route::controller('articles', 'ArticleController');
    Route::controller('series', 'SeriesController');
    Route::controller('media', 'MediaController');

    Route::controller('tags', 'TagController');

    Route::controller('users', 'UserController');
    Route::controller('/', 'MainController');
});

Route::get('access-denied', function () {
    return 'Access Denied.';
});

Route::get('blank', function () {
    return view('admin.blank');
});
