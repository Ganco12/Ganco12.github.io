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

Route::get('/', 'SiteController@roulette');
Route::get('/faq', 'SiteController@faq');
Route::get('/games', 'SiteController@games');

Route::get('/roulette', 'SiteController@roulette');
Route::get('/crash', 'SiteController@crash');
Route::get('/coinflip', 'SiteController@coinflip');
Route::get('/jackpot', 'SiteController@jackpot');
Route::get('/terms', 'SiteController@terms');

Route::get('/user/deposit', 'SiteController@deposit');
Route::get('/deposit', 'SiteController@redirect');
Route::get('/user/withdraw', 'SiteController@withdraw');
Route::get('/user/profile', 'SiteController@profile');
Route::get('/user/referrals', 'SiteController@referrals');

Route::get('auth/login', 'AuthController@login');
Route::get('/vklogin', 'LoginController@vklogin');
Route::get('auth/logout', 'LoginController@logout');

/*Оплата*/
Route::get('/pay', 'PagesController@pay');
Route::get('/getPayment', 'PagesController@getPayment');
Route::get('/success', 'PagesController@success');
/*Оплата*/



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

Route::get('api/transaction-history', 'ApiController@transaction_history');
Route::get('api/site-inventory', 'ApiController@site_inventory');
Route::get('api/free-coins', 'ApiController@free_coins');
Route::get('api/group-join', 'ApiController@group_join');
Route::get('earn/affiliates_collect30ndfsjedskllkvdlpjhjdsgdlksjdjwdjsdwjdhwdskwnkjdhadw', 'EarnController@affiliates_collect30ndfsjedskllkvdlpjhjdsgdlksjdjwdjsdwjdhwdskwnkjdhadw');
Route::post('api/affiliates-collect', 'ApiController@affiliates_collect');

/*adminka*/
Route::group(['middleware' => 'auth', 'middleware' => 'access:admin'], function () {
	Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index']);
	/* Players */
	Route::get('/admin/users', ['as' => 'users', 'uses' => 'AdminController@users']);
	Route::post('/admin/user/save', ['as' => 'user.save', 'uses' => 'AdminController@user_save']);
	Route::get('/admin/user/{id}/edit', ['as' => 'user.edit', 'uses' => 'AdminController@edit_user']);
	Route::get('/admin/user/{id}/ban', 'AdminController@ban_user');
	/* Cases */
	Route::get('/admin/cases', ['as' => 'cases', 'uses' => 'AdminController@cases']);
	Route::get('/admin/new_case', ['as' => 'new_case', 'uses' => 'AdminController@new_case']);
	Route::get('/admin/case/{id}/edit', ['as' => 'case.edit', 'uses' => 'AdminController@case_edit']);
	Route::get('/admin/case/{id}/delete', ['as' => 'case.delete', 'uses' => 'AdminController@case_delete']);
	Route::get('/admin/item/{id}/add', ['as' => 'item.add', 'uses' => 'AdminController@item_add']);
	Route::get('/admin/item/{id}/edit', ['as' => 'item.edit', 'uses' => 'AdminController@item_edit']);
	Route::get('/admin/item/{id}/delete', ['as' => 'item.delete', 'uses' => 'AdminController@item_delete']);
	Route::post('/admin/item/add', ['as' => 'item.save', 'uses' => 'AdminController@item_create']);
	Route::post('/admin/item/update', ['as' => 'item.update', 'uses' => 'AdminController@item_update']);
	Route::post('/admin/case/save', ['as' => 'case.save', 'uses' => 'AdminController@add_case']);
	Route::post('/admin/case/update', ['as' => 'case.upd', 'uses' => 'AdminController@case_update']);
	/* Withdraw */
	Route::get('/admin/withdraw', ['as' => 'withdraw', 'uses' => 'AdminController@withdraw']);
	Route::post('/admin/withdraw/save', ['as' => 'withdraw.save', 'uses' => 'AdminController@withdraw_save']);
	Route::get('/admin/withdraw/{id}/edit', ['as' => 'withdraw.edit', 'uses' => 'AdminController@edit_withdraw']);
	/*Payments*/
	Route::get('/admin/payments', 'AdminController@payments');
	/*promocodes*/
	Route::get('/admin/promocodes', 'AdminController@promocodes');
	Route::post('/admin/createpromo', 'AdminController@createpromo');
	/*support*/
	Route::get('/admin/support', 'AdminController@sup');
	Route::get('/admin/support/{id}/close', 'AdminController@sup_close');
});
/*adminka*/