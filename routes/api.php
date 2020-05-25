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
/*API*/
Route::get('/ajax/get_rand', 'PagesController@get_rand');
Route::get('/ajax/refresh_balance', 'PagesController@refresh_balance');
Route::get('/ajax/get_drop', 'PagesController@get_drop');
Route::get('/ajax/get_drop_m', 'PagesController@get_drop');
Route::get('/cashout', 'PagesController@cashout');
Route::post('/api/stats', 'PagesController@stats');
Route::get('/ajax/refresh_opens', 'PagesController@refresh_opens');
Route::get('/ajax/contact', 'PagesController@supports');
/*API*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/5840-2383r39r402830r9r4085-ifrf-459', function() {
     return Input::all();
});