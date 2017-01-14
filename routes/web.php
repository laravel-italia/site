<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::group(['prefix' => 'categories'], function(){
        Route::get('delete/{categoryId}', 'CategoryController@getDelete');
        Route::post('edit/{categoryId}', 'CategoryController@postEdit');
        Route::get('details/{categoryId}', 'CategoryController@getDetails');
        Route::post('add', 'CategoryController@postAdd');
        Route::get('/', 'CategoryController@getIndex');
    });

    Route::group(['prefix' => 'templates'], function(){
        Route::get('find/{templateId}', 'TemplateController@getFind');
        Route::get('delete/{templateId}', 'TemplateController@getDelete');
        Route::post('edit/{templateId}', 'TemplateController@postEdit');
        Route::get('edit/{templateId}', 'TemplateController@getEdit');
        Route::post('add', 'TemplateController@postAdd');
        Route::get('add', 'TemplateController@getAdd');
        Route::get('/', 'TemplateController@getIndex');
    });

    Route::group(['prefix' => 'articles'], function(){
        Route::get('preview/{articleId}', 'ArticleController@getPreview');
        Route::get('delete/{articleId}', 'ArticleController@getDelete');
        Route::get('unpublish/{seriesId}', 'ArticleController@getUnpublish');
        Route::post('publish/{articleId}', 'ArticleController@postPublish');
        Route::post('edit/{articleId}', 'ArticleController@postEdit');
        Route::get('edit/{articleId}', 'ArticleController@getEdit');
        Route::post('add', 'ArticleController@postAdd');
        Route::get('add', 'ArticleController@getAdd');
        Route::get('/', 'ArticleController@getIndex');
    });

    Route::group(['prefix' => 'series'], function(){
        Route::get('delete/{seriesId}', 'SeriesController@getDelete');
        Route::post('edit/{seriesId}', 'SeriesController@postEdit');
        Route::get('edit/{seriesId}', 'SeriesController@getEdit');
        Route::get('incomplete/{seriesId}', 'SeriesController@getIncomplete');
        Route::get('complete/{seriesId}', 'SeriesController@getComplete');
        Route::get('unpublish/{seriesId}', 'SeriesController@getUnpublish');
        Route::get('publish/{seriesId}', 'SeriesController@getPublish');
        Route::post('add', 'SeriesController@postAdd');
        Route::get('add', 'SeriesController@getAdd');
        Route::get('/', 'SeriesController@getIndex');
    });

    Route::group(['prefix' => 'media'], function(){
        Route::get('delete/{mediaId}', 'MediaController@getDelete');
        Route::post('upload', 'MediaController@postUpload');
        Route::get('/', 'MediaController@getIndex');
    });

    Route::group(['prefix' => 'users'], function(){
        Route::get('search-criteria', 'UserController@getSearchCriteria');
        Route::post('change-picture', 'UserController@postChangePicture');
        Route::post('invite', 'UserController@postInvite');
        Route::get('switch/{userId}/{roleName}', 'UserController@getSwitch');
        Route::get('unblock/{userId}', 'UserController@getUnblock');
        Route::get('block/{userId}', 'UserController@getBlock');
        Route::get('/', 'UserController@getIndex');
    });

    Route::get('access-denied', 'MainController@getAccessDenied');
    Route::post('reset', 'MainController@postReset');
    Route::get('reset', 'MainController@getReset');
    Route::post('recovery', 'MainController@postRecovery');
    Route::get('recovery', 'MainController@getRecovery');
    Route::post('invitation', 'MainController@postInvitation');
    Route::get('invitation', 'MainController@getInvitation');
    Route::get('logout', 'MainController@getLogout');
    Route::post('login', 'MainController@postLogin');
    Route::get('login', 'MainController@getLogin');
    Route::get('dashboard', 'MainController@getDashboard');
    Route::get('/', 'MainController@getIndex');
});

Route::get('sso/redirect', 'DiscourseSSOController@getRedirect');
Route::get('sso/callback', 'DiscourseSSOController@getCallback');
Route::get('sso/logout', 'DiscourseSSOController@getLogout');

Route::get('articoli/{slug}/{slug2?}', 'FrontController@getArticle');
Route::get('articoli', 'FrontController@getArticles');
Route::get('serie/{slug}', 'FrontController@getSeriesFirstArticle');
Route::get('serie', 'FrontController@getSeries');
Route::get('privacy', 'FrontController@getPrivacyPolicy');
Route::get('/', 'FrontController@getIndex');
