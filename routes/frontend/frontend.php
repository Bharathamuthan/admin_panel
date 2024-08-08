<?php

Route::get('login', 'Auth\Admin\LoginController@login')->name('admin.auth.login');

Route::get('/viewNews/{blog}', 'HomeController@viewNews');
