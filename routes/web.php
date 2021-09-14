<?php

use Illuminate\Support\Facades\Auth;
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

//index
Route::get('/', '\App\Http\Controllers\Controller@index')->name('home');


//Books
Route::get('books/add', '\App\Http\Controllers\BooksController@add')->name('addBook');
Route::post('books/add', '\App\Http\Controllers\BooksController@store')->name('addBook');

Route::get('books/list', '\App\Http\Controllers\BooksController@showAllData')->name('booksList');
Route::get('books/preview/{id}', '\App\Http\Controllers\BooksController@show')->name('previewBook');

Route::get('books/edit/{id}', '\App\Http\Controllers\BooksController@edit')->name('editBook');
Route::post('books/edit/{id}', '\App\Http\Controllers\BooksController@update')->name('editBook');

Route::get('books/delete/{id}', '\App\Http\Controllers\BooksController@destroy')->name('deleteBook');


//Clients
Route::get('clients/add', '\App\Http\Controllers\ClientsController@add')->name('addClient');
Route::post('clients/add', '\App\Http\Controllers\ClientsController@store')->name('addClient');

Route::get('clients/list', '\App\Http\Controllers\ClientsController@showAllData')->name('clientsList');
Route::get('clients/preview/{id}', '\App\Http\Controllers\ClientsController@show')->name('previewClient');

Route::get('clients/edit/{id}', '\App\Http\Controllers\ClientsController@edit')->name('editClient');
Route::post('clients/edit/{id}', '\App\Http\Controllers\ClientsController@update')->name('editClient');

Route::get('clients/delete/{id}', '\App\Http\Controllers\ClientsController@destroy')->name('deleteClient');

/**** Orders ****/
//sales
Route::get('orders/sales/add', '\App\Http\Controllers\OrdersController@showSale')->name('addSale');

Route::post('orders/sales/add', '\App\Http\Controllers\OrdersController@updateStock')->name('updateStock');

//orders
Route::get('orders/add', '\App\Http\Controllers\OrdersController@add')->name('addOrder');
Route::post('orders/add', '\App\Http\Controllers\OrdersController@store')->name('addOrder');
Route::post('orders/addBook/{id}', '\App\Http\Controllers\OrdersController@storeBook')->name('addOrderBook');

Route::get('orders/list', '\App\Http\Controllers\OrdersController@showAllData')->name('ordersList');
Route::get('orders/preview/{id}', '\App\Http\Controllers\OrdersController@show')->name('previewOrder');
Route::get('orders/print/{id}', '\App\Http\Controllers\OrdersController@print')->name('printOrder');

Route::get('orders/edit/{id}', '\App\Http\Controllers\OrdersController@edit')->name('editOrder');
Route::post('orders/edit/{id}', '\App\Http\Controllers\OrdersController@update')->name('editOrder');

Route::delete('orders/delete/{id}/{book_id}', '\App\Http\Controllers\OrdersController@destroyBook')->name('deleteOrderBook');
Route::delete('orders/delete/{id}', '\App\Http\Controllers\OrdersController@destroy')->name('deleteOrder');

//Reports
Route::get('report', '\App\Http\Controllers\ReportController@showAllData')->name('report');

// ***** Settings ***** //
//Database
Route::get('settings/database', '\App\Http\Controllers\DatabaseController@show')->name('settingsDatabase');
Route::get('settings/dropDB', '\App\Http\Controllers\DatabaseController@dropDB')->name('dropDB');
Route::post('settings/importDB', '\App\Http\Controllers\DatabaseController@importDB')->name('importDB');
Route::get('settings/exportDB', '\App\Http\Controllers\DatabaseController@exportDB')->name('exportDB');

//Books
Route::get('settings/books', '\App\Http\Controllers\BooksController@settingBooks')->name('settingsBooks');
Route::post('settings/importExcelBooks', '\App\Http\Controllers\BooksController@importExcel')->name('importExcelBooks');
Route::get('settings/exportExcelBooks', '\App\Http\Controllers\BooksController@exportExcel')->name('exportExcelBooks');

//Clients
Route::get('settings/clients', '\App\Http\Controllers\ClientsController@settingClients')->name('settingsClients');
Route::post('settings/importExcelClients', '\App\Http\Controllers\ClientsController@importExcel')->name('importExcelClients');
Route::get('settings/exportExcelClients', '\App\Http\Controllers\ClientsController@exportExcel')->name('exportExcelClients');

//Accounts
Route::get('settings/accounts/add', '\App\Http\Controllers\AccountsController@showAdd')->name('settingsAddAccount');
Route::post('settings/accounts/add', '\App\Http\Controllers\AccountsController@store')->name('createAccount');

Route::get('settings/accounts/edit', '\App\Http\Controllers\AccountsController@showEdit')->name('settingsEditAccount');
Route::post('settings/accounts/edit', '\App\Http\Controllers\AccountsController@update')->name('updateAccount');

Route::get('settings/accounts/delete', '\App\Http\Controllers\AccountsController@showDelete')->name('settingsDeleteAccount');
Route::delete('settings/accounts/delete', '\App\Http\Controllers\AccountsController@destroy')->name('deleteAccount');

// ***** Trash ***** //

//Books
Route::get('trash/books', '\App\Http\Controllers\BooksController@showTrashed')->name('trashedBooks');
Route::post('trash/books/restore/{id}', '\App\Http\Controllers\BooksController@restoreTrashed')->name('restoreTrashedBook');
Route::delete('trash/books/delete/{id}', '\App\Http\Controllers\BooksController@dropTrashed')->name('deleteTrashedBook');

//Clients
Route::get('trash/clients', '\App\Http\Controllers\ClientsController@showTrashed')->name('trashedClients');
Route::post('trash/clients/restore/{id}', '\App\Http\Controllers\ClientsController@restoreTrashed')->name('restoreTrashedClient');
Route::delete('trash/clients/delete/{id}', '\App\Http\Controllers\ClientsController@dropTrashed')->name('deleteTrashedClient');

//Orders
Route::get('trash/orders', '\App\Http\Controllers\OrdersController@showTrashed')->name('trashedOrders');
Route::post('trash/orders/restore/{id}', '\App\Http\Controllers\OrdersController@restoreTrashed')->name('restoreTrashedOrder');
Route::delete('trash/orders/delete/{id}', '\App\Http\Controllers\OrdersController@dropTrashed')->name('deleteTrashedOrder');

//Users
Route::get('trash/users', '\App\Http\Controllers\AccountsController@showTrashed')->name('trashedUsers');
Route::post('trash/users/restore/{id}', '\App\Http\Controllers\AccountsController@restoreTrashed')->name('restoreTrashedUser');
Route::delete('trash/users/delete/{id}', '\App\Http\Controllers\AccountsController@dropTrashed')->name('deleteTrashedUser');


Auth::routes();

/*****
//disable registration options
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);
****/
