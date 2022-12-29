<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Passport::routes();

Route::get('/students/search','StudentController@Search');
Route::apiResource('/students', 'StudentController');
Route::post('/register','AuthController@register');
Route::post('/login','AuthController@login');

Route::group(['middleware' => 'auth:api'], function (){
    Route::get('/logout','AuthController@logout');
    Route::get('/user','AuthController@user');
});
