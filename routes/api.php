<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', 'API\UserController@login');

Route::get('details', 'API\UserController@index');





Route::group([
    'middleware' => 'auth:api'
  ], function() {
    Route::post('create', 'API\UserController@store');
    //   Route::get('user', 'AuthController@user');
      Route::post('update/{id}','API\UserController@update');
      Route::get('logout', 'API\UserController@logout');
      Route::post('search','API\UserController@filter');
      Route::post('sort','API\UserController@sortUser');
      Route::delete('delete/{id}','API\UserController@destroy');
      Route::get('/export/users', 'ExportUserController@exportUsers')->name('usersExport');
      Route::get('/download/users', 'ExportUserController@showUsersDownload')->name('showUsersDownload');
      Route::get('/download/users-file', 'ExportUserController@downloadUsers')->name('usersDownload');
  });
// Route::get('edit/{user}','API\UserController@edit');

// Route::get('logout', 'API\UserController@logout');