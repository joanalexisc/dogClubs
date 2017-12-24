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

//NECESITA ESTO aun no se ssabe para que porque igual manda el correo, el controlador PasswordController no existe puedo
//poner pepito y seguira funcionando...
// Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset');
// Route::post('JOAN', 'Auth\ResetPasswordController@reset')->name('password.reset');


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
// Route::get('password/reset', 'AuthController@showResetForm');


Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm');

Route::post('authenticate', 'AuthController@authenticate');
//------------------Roles & permissions----------------------------------
Route::group(['middleware' => ['ability:admin,create-users']], function()
{
Route::post('role', 'AuthController@createRole');
Route::post('permission', 'AuthController@createPermission');
Route::post('assign-role', 'AuthController@assignRole');
Route::post('attach-permission', 'AuthController@attachPermission');

//'prefix' => 'api',

    // Route::get('users', 'AuthController@dummy');
});

// Authentication route






Route::group(['middleware' => ['jwt.auth']], function() {
    Route::post('logout', 'AuthController@logout');
   
   
});