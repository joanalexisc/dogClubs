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

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
//validate mail
Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
Route::get('token', 'AuthController@token');


Route::post('recover', 'AuthController@recover');


Route::post('role', 'AuthController@createRole');
Route::post('permission', 'AuthController@createPermission');
Route::post('assign-role', 'AuthController@assignRole');
Route::post('attach-permission', 'AuthController@attachPermission');

//'prefix' => 'api',
Route::group(['middleware' => ['ability:admin,create-users']], function()
{
    Route::get('users', 'AuthController@dummy');
});

// Authentication route
Route::post('authenticate', 'AuthController@authenticate');



Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::group(['middleware' => ['jwt.auth']], function() {
    Route::post('logout', 'AuthController@logout');
   
   
});