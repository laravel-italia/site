<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::controller('categories', 'CategoryController');
    Route::controller('articles', 'ArticleController');
    Route::controller('series', 'SeriesController');
    Route::controller('media', 'MediaController');

    Route::controller('users', 'UserController');
    Route::controller('/', 'MainController');
});

Route::get('access-denied', function () {
    return 'Access Denied.';
});

Route::get('articoli/{slug}', 'FrontController@getArticle');
Route::get('articoli', 'FrontController@getArticles');
Route::get('serie/{slug}', 'FrontController@getSeriesFirstArticle');
Route::get('serie', 'FrontController@getSeries');
Route::get('/', 'FrontController@getIndex');
