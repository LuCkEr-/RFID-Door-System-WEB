<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Log;

Auth::routes();

// Dashboard
Route::get('/', 'DashboardController@index');

// Add Accounts
Route::get('/accounts', 'AccountsController@index');
Route::post('/accounts', 'AccountsController@create');
Route::get('/accounts/{id}', 'AccountsController@edit');
Route::patch('/accounts/{id}/cards', 'AccountsController@updateCards');

Route::post('/accounts/store', 'AccountsController@store');
Route::post('/accounts/import', 'AccountsController@import');
Route::post('/accounts/delete', 'AccountsController@delete');
Route::post('/accounts/insert', 'AccountsController@insert');

// Cards
Route::get('/cards', 'CardsController@index');
Route::post('/cards', 'CardsController@store');

Route::get('/cards/{id}', 'CardsController@edit');
Route::patch('/cards/{id}', 'CardsController@update');
Route::post('/cards/insert', 'CardsController@create');
Route::post('/cards/delete', 'CardsController@delete');

// Groups
Route::get('/groups', 'GroupsController@index');
Route::post('/groups/insert', 'GroupsController@create');
Route::post('/groups/delete', 'GroupsController@remove');

Route::get('/groups/{id}', 'GroupsController@edit');

// logs
Route::get('/logs', 'LogsController@index');

// Oauth Tokens
Route::get('/tokens', 'SettingsController@tokens');

// Setup
Route::get('/setup', 'SetupController@Setup') -> middleware('guest');
