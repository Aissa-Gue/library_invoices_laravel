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


/******** Authentication ********/
//Auth::routes();

//disable registration options
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::group(['middleware' => ['auth', 'admin']], function () {

    /********* Dashboard [home] *********/

    Route::get('/', '\App\Http\Controllers\DashboardController@index')->name('home');
    Route::get('/dashboard/clientsDebts', '\App\Http\Controllers\DashboardController@clientsDebts')->name('clientsDebts');
    Route::get('/dashboard/providersDebts', '\App\Http\Controllers\DashboardController@providersDebts')->name('providersDebts');
    Route::get('/dashboard/stockAlerts', '\App\Http\Controllers\DashboardController@stockAlerts')->name('stockAlerts');

    /********* PROVIDERS *********/

    Route::get('providers/add', '\App\Http\Controllers\ProvidersController@add')->name('addProvider');
    Route::post('providers/add', '\App\Http\Controllers\ProvidersController@store')->name('addProvider');
    Route::post('providers/addAsClient/{id}', '\App\Http\Controllers\ProvidersController@addAsClient')->name('addAsClient');

    Route::get('providers/list', '\App\Http\Controllers\ProvidersController@showAllData')->name('providersList');
    Route::get('providers/preview/{id}', '\App\Http\Controllers\ProvidersController@show')->name('previewProvider');

    Route::get('providers/edit/{id}', '\App\Http\Controllers\ProvidersController@edit')->name('editProvider');
    Route::put('providers/edit/{id}', '\App\Http\Controllers\ProvidersController@update')->name('editProvider');

    Route::delete('providers/delete/{id}', '\App\Http\Controllers\ProvidersController@destroy')->name('deleteProvider');


    /******** PURCHASES ********/

    Route::get('purchases/add/{provider_id?}', '\App\Http\Controllers\PurchasesController@add')->name('addPurchase');
    Route::post('purchases/add', '\App\Http\Controllers\PurchasesController@store')->name('addPurchase');
    Route::post('purchases/addBook/{id}', '\App\Http\Controllers\PurchasesController@storeBook')->name('addPurchaseBook');
    Route::get('purchases/addBook/alert/{id}', '\App\Http\Controllers\PurchasesController@purchasePriceAlert')->name('purchasePriceAlert');

    Route::get('purchases/list', '\App\Http\Controllers\PurchasesController@showAllData')->name('purchasesList');
    Route::get('purchases/preview/{id}', '\App\Http\Controllers\PurchasesController@show')->name('previewPurchase');
    Route::get('purchases/print/{id}', '\App\Http\Controllers\PurchasesController@print')->name('printPurchase');

    Route::get('purchases/edit/{id}', '\App\Http\Controllers\PurchasesController@edit')->name('editPurchase');
    Route::put('purchases/edit/{id}', '\App\Http\Controllers\PurchasesController@update')->name('editPurchase');
    Route::put('purchases/edit/salePercentage/{id}', '\App\Http\Controllers\PurchasesController@updateSalePercentage')->name('editSalePercentage');

    Route::delete('purchases/delete/{id}/{book_id}', '\App\Http\Controllers\PurchasesController@destroyBook')->name('deletePurchaseBook');
    Route::delete('purchases/delete/{id}', '\App\Http\Controllers\PurchasesController@destroy')->name('deletePurchase');


    /********* Settings *********/
    //Database
    Route::get('settings/database', '\App\Http\Controllers\DatabaseController@show')->name('settingsDatabase');
    Route::delete('settings/dropDB', '\App\Http\Controllers\DatabaseController@dropDB')->name('dropDB');
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

    //Providers
    Route::get('settings/providers', '\App\Http\Controllers\ProvidersController@settingProviders')->name('settingsProviders');
    Route::post('settings/importExcelProviders', '\App\Http\Controllers\ProvidersController@importExcel')->name('importExcelProviders');
    Route::get('settings/exportExcelProviders', '\App\Http\Controllers\ProvidersController@exportExcel')->name('exportExcelProviders');

    //Accounts
    Route::get('settings/accounts/add', '\App\Http\Controllers\UsersController@showAdd')->name('settingsAddAccount');
    Route::post('settings/accounts/add', '\App\Http\Controllers\UsersController@store')->name('createAccount');

    Route::get('settings/accounts/edit', '\App\Http\Controllers\UsersController@showEdit')->name('settingsEditAccount');
    Route::put('settings/accounts/edit', '\App\Http\Controllers\UsersController@update')->name('updateAccount');

    Route::get('settings/accounts/delete', '\App\Http\Controllers\UsersController@showDelete')->name('settingsDeleteAccount');
    Route::delete('settings/accounts/delete', '\App\Http\Controllers\UsersController@destroy')->name('deleteAccount');

    /********* Trash *********/

    //Books
    Route::get('trash/books', '\App\Http\Controllers\BooksController@showTrashed')->name('trashedBooks');
    Route::post('trash/books/restore/{id}', '\App\Http\Controllers\BooksController@restoreTrashed')->name('restoreTrashedBook');
    Route::delete('trash/books/delete/{id}', '\App\Http\Controllers\BooksController@dropTrashed')->name('deleteTrashedBook');

    //Clients
    Route::get('trash/clients', '\App\Http\Controllers\ClientsController@showTrashed')->name('trashedClients');
    Route::post('trash/clients/restore/{id}', '\App\Http\Controllers\ClientsController@restoreTrashed')->name('restoreTrashedClient');
    Route::delete('trash/clients/delete/{id}', '\App\Http\Controllers\ClientsController@dropTrashed')->name('deleteTrashedClient');

    //Providers
    Route::get('trash/providers', '\App\Http\Controllers\ProvidersController@showTrashed')->name('trashedProviders');
    Route::post('trash/providers/restore/{id}', '\App\Http\Controllers\ProvidersController@restoreTrashed')->name('restoreTrashedProvider');
    Route::delete('trash/providers/delete/{id}', '\App\Http\Controllers\ProvidersController@dropTrashed')->name('deleteTrashedProvider');

    //Sales
    Route::get('trash/sales', '\App\Http\Controllers\SalesController@showTrashed')->name('trashedSales');
    Route::post('trash/sales/restore/{id}', '\App\Http\Controllers\SalesController@restoreTrashed')->name('restoreTrashedSale');
    Route::delete('trash/sales/delete/{id}', '\App\Http\Controllers\SalesController@dropTrashed')->name('deleteTrashedSale');

    //Orders
    Route::get('trash/orders', '\App\Http\Controllers\OrdersController@showTrashed')->name('trashedOrders');
    Route::post('trash/orders/restore/{id}', '\App\Http\Controllers\OrdersController@restoreTrashed')->name('restoreTrashedOrder');
    Route::delete('trash/orders/delete/{id}', '\App\Http\Controllers\OrdersController@dropTrashed')->name('deleteTrashedOrder');

    //Purchases
    Route::get('trash/purchases', '\App\Http\Controllers\PurchasesController@showTrashed')->name('trashedPurchases');
    Route::post('trash/purchases/restore/{id}', '\App\Http\Controllers\PurchasesController@restoreTrashed')->name('restoreTrashedPurchase');
    Route::delete('trash/purchases/delete/{id}', '\App\Http\Controllers\PurchasesController@dropTrashed')->name('deleteTrashedPurchase');

    //Users
    Route::get('trash/users', '\App\Http\Controllers\UsersController@showTrashed')->name('trashedUsers');
    Route::post('trash/users/restore/{id}', '\App\Http\Controllers\UsersController@restoreTrashed')->name('restoreTrashedUser');
    Route::delete('trash/users/delete/{id}', '\App\Http\Controllers\UsersController@dropTrashed')->name('deleteTrashedUser');
});

/********* BOOKS *********/

Route::get('books/add', '\App\Http\Controllers\BooksController@add')->name('addBook');
Route::post('books/add', '\App\Http\Controllers\BooksController@store')->name('addBook');

Route::get('books/list', '\App\Http\Controllers\BooksController@showAllData')->name('booksList');
Route::get('books/preview/{id}', '\App\Http\Controllers\BooksController@show')->name('previewBook');

Route::get('books/edit/{id}', '\App\Http\Controllers\BooksController@edit')->name('editBook');
Route::put('books/edit/{id}', '\App\Http\Controllers\BooksController@update')->name('editBook');

Route::delete('books/delete/{id}', '\App\Http\Controllers\BooksController@destroy')->name('deleteBook');


/********* CLIENTS *********/

Route::get('clients/add', '\App\Http\Controllers\ClientsController@add')->name('addClient');
Route::post('clients/add', '\App\Http\Controllers\ClientsController@store')->name('addClient');
Route::post('clients/addAsProvider/{id}', '\App\Http\Controllers\ClientsController@addAsProvider')->name('addAsProvider');

Route::get('clients/list', '\App\Http\Controllers\ClientsController@showAllData')->name('clientsList');
Route::get('clients/preview/{id}', '\App\Http\Controllers\ClientsController@show')->name('previewClient');

Route::get('clients/edit/{id}', '\App\Http\Controllers\ClientsController@edit')->name('editClient');
Route::put('clients/edit/{id}', '\App\Http\Controllers\ClientsController@update')->name('editClient');

Route::delete('clients/delete/{id}', '\App\Http\Controllers\ClientsController@destroy')->name('deleteClient');


/******** SALES ********/
//sales
Route::get('orders/sales/add', '\App\Http\Controllers\SalesController@addSale')->name('addSale');
Route::post('orders/sales/add', '\App\Http\Controllers\SalesController@store')->name('updateStock');
Route::delete('orders/sales/delete/{id}', '\App\Http\Controllers\SalesController@destroy')->name('deleteSale');


/******** ORDERS ********/

//orders
Route::get('orders/add/{client_id?}', '\App\Http\Controllers\OrdersController@add')->name('addOrder');
Route::post('orders/add', '\App\Http\Controllers\OrdersController@store')->name('addOrder');
Route::post('orders/addBook/{id}', '\App\Http\Controllers\OrdersController@storeBook')->name('addOrderBook');

Route::get('orders/list', '\App\Http\Controllers\OrdersController@showAllData')->name('ordersList');
Route::get('orders/preview/{id}', '\App\Http\Controllers\OrdersController@show')->name('previewOrder');
Route::get('orders/print/{id}', '\App\Http\Controllers\OrdersController@print')->name('printOrder');

Route::get('orders/edit/{id}', '\App\Http\Controllers\OrdersController@edit')->name('editOrder');
Route::put('orders/edit/{id}', '\App\Http\Controllers\OrdersController@update')->name('editOrder');

Route::delete('orders/delete/{id}/{book_id}', '\App\Http\Controllers\OrdersController@destroyBook')->name('deleteOrderBook');
Route::delete('orders/delete/{id}', '\App\Http\Controllers\OrdersController@destroy')->name('deleteOrder');