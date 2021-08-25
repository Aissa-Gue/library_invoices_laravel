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

//Orders
Route::get('orders/add', '\App\Http\Controllers\OrdersController@add')->name('addOrder');
Route::post('orders/add', '\App\Http\Controllers\OrdersController@store')->name('addOrder');
Route::post('orders/addBook/{id}', '\App\Http\Controllers\OrdersController@storeBook')->name('addOrderBook');

Route::get('orders/list', '\App\Http\Controllers\OrdersController@showAllData')->name('ordersList');
Route::get('orders/preview/{id}', '\App\Http\Controllers\OrdersController@show')->name('previewOrder');

Route::get('orders/edit/{id}', '\App\Http\Controllers\OrdersController@edit')->name('editOrder');
Route::post('orders/edit/{id}', '\App\Http\Controllers\OrdersController@update')->name('editOrder');

Route::delete('orders/delete/{id}/{book_id}', '\App\Http\Controllers\OrdersController@destroyBook')->name('deleteOrderBook');
Route::delete('orders/delete/{id}', '\App\Http\Controllers\OrdersController@destroy')->name('deleteOrder');

//Reports
Route::get('report', '\App\Http\Controllers\ReportController@showAllData')->name('report');
Route::get('settings/list', '\App\Http\Controllers\SettingsController@showAllData')->name('settings');

