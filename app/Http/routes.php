<?php

Route::get('login', function(){
   return view('admin.login');
});

Route::get('blank', function () {
    return view('admin.blank');
});
