<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'UserController@list')->name('users.list');

Route::get('/user/{id}', 'ProfileController@index')->name('profile.index')->middleware('auth');

Route::post('/user_accounts/create', 'AccountController@create')->name('account.create');
Route::get('/user_accounts/{id}/delete', 'AccountController@destroy')->middleware('auth')->name('account.delete');

Route::post('/money/transfer', 'MoneyTransferController@index')->name('money.transfer');

Route::get('/user/{id}/transactions', 'TransactionController@index')->name('profile.transactions');


