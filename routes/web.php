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

Route::get('/', 'LoginController@index')->name('welcome');

Route::get('/login', 'LoginController@login')->name('login');
Route::post('/login', 'LoginController@loginPost');
Route::post('/logout', 'LoginController@logoutPost')->name('logout');

Route::middleware(['auth'])->group(function() {
	Route::get('/home', 'HomeController@index')->name('home.index');
	Route::get('/home/create/wash', 'HomeController@createWash')->name('home.create.wash');
	Route::get('/home/wash/{wash}/calculate', 'HomeController@calculateWash')->name('home.wash.calculate');
	Route::get('/home/wash/{wash}/add/beverage', 'HomeController@addBeverage')->name('home.wash.add.beverage');
	Route::get('/home/show/product/{name?}', 'HomeController@showProduct')->name('home.show.product');
	Route::get('/home/print/invoice/{transaction}', 'HomeController@printInvoice')->name('home.print.invoice');
	Route::post('/home/store/wash', 'HomeController@storeWash')->name('home.store.wash');
	Route::post('/home/wash/{wash}/add/beverage', 'HomeController@addBeveragePost');
	Route::post('/home/non-wash-transaction', 'HomeController@storeNonWashTransaction')->name('home.non-wash-transaction');
	Route::delete('/home/wash/{wash}/check', 'HomeController@checkWashDelete')->name('home.wash.check');

	Route::get('/password/change', 'LoginController@passwordChange')->name('password.change');
	Route::post('/password/change', 'LoginController@passwordChangePost');

	Route::get('/expenditures/list', 'ExpenditureController@dataList')->name('expenditures.list');
	Route::resource('/expenditures', 'ExpenditureController');

	Route::get('/mechanics/list', 'MechanicController@dataList')->name('mechanics.list');
	Route::post('/mechanics/{mechanic}/restore', 'MechanicController@restorePost')->name('mechanics.restore');
	Route::resource('/mechanics', 'MechanicController');

	Route::get('/products/{type?}/list', 'ProductController@dataList')->name('products.list');
	Route::get('/products/{type?}', 'ProductController@index')->name('products.index');
	Route::get('/products/{type?}/create', 'ProductController@create')->name('products.create');
	Route::get('/products/{type?}/show/{product}', 'ProductController@show')->name('products.show');
	Route::get('/products/{type?}/show/{product}/edit', 'ProductController@edit')->name('products.edit');
	Route::put('/products/{type?}/show/{product}', 'ProductController@update')->name('products.update');
	Route::any('/products/{type?}/show/{product}/destroy', 'ProductController@destroy')->name('products.destroy');
	Route::post('/products/{type?}/create', 'ProductController@store')->name('products.store');
	Route::post('/products/{type?}/show/{product}/restore', 'ProductController@restorePost')->name('products.restore');

	Route::get('/purchases/list', 'PurchaseController@dataList')->name('purchases.list');
	Route::resource('/purchases', 'PurchaseController');

	Route::get('/reports/list', 'ReportController@dataList')->name('reports.list');
	Route::resource('/reports', 'ReportController');

	Route::get('/tools/list', 'ToolController@dataList')->name('tools.list');
	Route::resource('/tools', 'ToolController');

	Route::get('/transactions/list', 'TransactionController@dataList')->name('transactions.list');
	Route::resource('/transactions', 'TransactionController');

	Route::get('/users/list', 'UserController@dataList')->name('users.list');
	Route::post('/users/{user}/restore', 'UserController@restorePost')->name('users.restore');
	Route::resource('/users', 'UserController');

	Route::get('/user-logs/list', 'UserLogController@dataList')->name('user-logs.list');
	Route::resource('/user-logs', 'UserLogController', ['only' => ['index', 'show']]);

	Route::get('/washes/list', 'WashController@dataList')->name('washes.list');
	Route::resource('/washes', 'WashController');

	Route::get('/washing-rates/list', 'WashingRateController@dataList')->name('washing-rates.list');
	Route::post('/washing-rates/{washing_rate}/restore', 'WashingRateController@restorePost')->name('washing-rates.restore');
	Route::resource('/washing-rates', 'WashingRateController');
});
