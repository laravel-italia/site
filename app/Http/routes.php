<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::controller('/', 'MainController');
});

Route::get('blank', function () {
    return view('admin.blank');
});
