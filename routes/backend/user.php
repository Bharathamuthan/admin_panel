<?php
Route::resource('users', 'UserDashboardController');
Route::get('/dashboard', 'UserDashboardController@index')->name('dashboard');
Route::get('/excel', 'UserDashboardController@excelList')->name('excel');
// Route::get('/edit', 'Backend\user\UserDashboardController@edit')->name('edit');
Route::get('/users', 'UserDashboardController@getAll')->name('users');
Route::get('/get-users', 'Backend\user\UserDashboardController@getUsers')->name('get-users');
Route::post('/toggle-user-status', 'UserDashboardController@toggleUserStatus')->name('toggleUserStatus');

// Admin
Route::get('/profile', 'UserDashboardController@profile')->name('profile');
Route::get('/edit_profile', 'UserDashboardController@edit')->name('edit');
Route::patch('/edit_profile', 'UserDashboardController@update')->name('update');
Route::get('/change_password', 'UserDashboardController@change_password')->name('password_change');
Route::patch('/change_password', 'UserDashboardController@update_password')->name('change_password');
