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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });




//-------------------user-----------------------------
Route::post('user', 'UserController@create');

Route::group(['middleware' => ['jwt.auth']], function() {
	Route::get('user', 'UserController@index');    
    Route::get('user/{id?}', 'UserController@show');
    Route::put('user/{id?}', 'UserController@update');
});
//------------------Authorization---------------------
Route::post('login', 'AuthController@login');
Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
Route::get('token', 'AuthController@token');
Route::post('recover', 'AuthController@recover');
Route::group(['middleware' => ['jwt.auth']], function() {
	Route::post('logout', 'AuthController@logout');
});
//------------------Roles & permissions----------------------------------

Route::group(['middleware' => ['ability:admin,create-users']], function()
{
	Route::post('role', 'AuthController@createRole');
	Route::post('permission', 'AuthController@createPermission');
	Route::post('assign-role', 'AuthController@assignRole');
	Route::post('attach-permission', 'AuthController@attachPermission');
});

// Authentication route







    
   
   
