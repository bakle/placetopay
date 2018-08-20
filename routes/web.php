<?php

use App\User;
use App\Transaction;
use App\Notifications\TransactionStatusChanged;

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

Route::get('/', 'HomeController@index')->name('show_checkout');
Route::get('transactions', 'TransactionController@index')->name('show_transactions');
Route::get('transaction/{transaction}', 'TransactionController@show')->name('show_transaction_detail');

Route::get('payment/create', 'PaymentController@create')->name('show_payment_form');
Route::post('payment/store', 'PaymentController@store')->name('store_payment');

Route::get('test', function() {
    //$user = User::first();
    $transaction = Transaction::first();
    $transaction->user->notify(new TransactionStatusChanged($transaction));
    return "yes";
});
