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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// API DataTables
Route::middleware('auth:api')->get('/account', 'Api\DataTablesController@account');
Route::middleware('auth:api')->get('/card', 'Api\DataTablesController@card');
Route::middleware('auth:api')->get('/group', 'Api\DataTablesController@group');
Route::middleware('auth:api')->get('/log', 'Api\DataTablesController@log');
Route::middleware('auth:api')->get('/elder', 'Api\DataTablesController@elder');

// API Search
Route::middleware('auth:api')->get('/account/search', 'Api\SearchController@account');
Route::middleware('auth:api')->get('/card/search', 'Api\SearchController@card');
Route::middleware('auth:api')->get('/group/search', 'Api\SearchController@group');
Route::middleware('auth:api')->get('/door/search', 'Api\SearchController@door');

// API Insert
Route::middleware('auth:api')->post('/log/insert', 'Api\MiscController@insertlog');

// API update
Route::middleware('auth:api')->post('/card/update/account', 'Api\CardController@updateAccount');
Route::middleware('auth:api')->post('/card/remove/account', 'Api\CardController@removeAccount');

Route::middleware('auth:api')->post('/card/update/vid', 'Api\CardController@updateVID');
Route::middleware('auth:api')->post('/card/update/rfid', 'Api\CardController@updateRFID');

Route::middleware('auth:api')->post('/account/update/fname', 'Api\AccountController@updateFName');
Route::middleware('auth:api')->post('/account/update/lname', 'Api\AccountController@updateLName');
Route::middleware('auth:api')->post('/account/update/email', 'Api\AccountController@updateEmail');
Route::middleware('auth:api')->post('/account/update/mobile', 'Api\AccountController@updateMobilePhone');
Route::middleware('auth:api')->post('/account/update/pcode', 'Api\AccountController@updatePersonalCode');

Route::middleware('auth:api')->post('/account/update/card', 'Api\AccountController@updateCard');
Route::middleware('auth:api')->post('/account/remove/card', 'Api\AccountController@removeCard');

Route::middleware('auth:api')->post('/account/update/group', 'Api\AccountController@updateGroup');
Route::middleware('auth:api')->post('/account/remove/group', 'Api\AccountController@removeGroup');

Route::middleware('auth:api')->post('/group/insert/time', 'Api\GroupController@insertTime');
Route::middleware('auth:api')->post('/group/remove/time', 'Api\GroupController@removeTime');

Route::middleware('auth:api')->post('/group/update/name', 'Api\GroupController@updateName');

Route::middleware('auth:api')->post('/group/update/door', 'Api\GroupController@updateDoor');
Route::middleware('auth:api')->post('/group/remove/door', 'Api\GroupController@removeDoor');

// API status
Route::middleware('auth:api')->post('/card/get/permission', 'Api\MiscController@getCardPermission');

Route::middleware('auth:api')->post('/card/get/account', 'Api\AutoCompleteController@getDefaultCardUser');

Route::middleware('auth:api')->post('/account/get/card', 'Api\AutoCompleteController@getDefaultUserCard');
Route::middleware('auth:api')->post('/account/get/group', 'Api\AutoCompleteController@getDefaultUserGroup');

Route::middleware('auth:api')->post('/group/get/door', 'Api\AutoCompleteController@getDefaultGroupDoor');
Route::middleware('auth:api')->post('/group/get/time', 'Api\AutoCompleteController@getDefaultGroupTime');



Route::middleware('auth:api')->post('/check/controller/token', 'Api\MiscController@checkControllerToken');
