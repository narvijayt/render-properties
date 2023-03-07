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

Route::post('/login', 'Auth\AuthController@login');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => [
        'jwt.auth',
		'jwt.refresh',
		'update_active',
    ],
    'as' => 'api.',
], function() {
	Route::get('/auth/user', 'Auth\UserController@index')->name('auth.user');

	Route::resource('/users', 'Users\UsersController', ['except' => 'edit']);

    /**
     * User Details routes
     */
	Route::get('/user-details', 'UserDetails\UserDetailsController@index')->name('user-details.index');
	Route::post('/user-details', 'UserDetails\UserDetailsController@store')->name('user-details.store');
	Route::get('/user-details/{userDetail}', 'UserDetails\UserDetailsController@show')->name('user-details.show');
	Route::put('/user-details/{userDetail}', 'UserDetails\UserDetailsController@update')->name('user-details.update');
	Route::delete('/user-details/{userDetail}', 'UserDetails\UserDetailsController@destroy')->name('user-details.destroy');

    /**
     * Realtor Sales routes
     */
    Route::get('/realtor-sales', 'RealtorSales\RealtorSalesController@index')->name('realtor-sales.index');
    Route::post('/realtor-sales', 'RealtorSales\RealtorSalesController@store')->name('realtor-sales.store');
    Route::get('/realtor-sales/{realtorSale}', 'RealtorSales\RealtorSalesController@show')->name('realtor-sales.show');
    Route::put('/realtor-sales/{realtorSale}', 'RealtorSales\RealtorSalesController@update')->name('realtor-sales.update');
    Route::delete('/realtor-sales/{realtorSale}', 'RealtorSales\RealtorSalesController@destroy')->name('realtor-sales.destroy');

	/**
	 * Broker Sales routes
	 */
	Route::get('/broker-sales', 'BrokerSales\BrokerSalesController@index')->name('broker-sales.index');
	Route::post('/broker-sales', 'BrokerSales\BrokerSalesController@store')->name('broker-sales.store');
	Route::get('/broker-sales/{brokerSale}', 'BrokerSales\BrokerSalesController@show')->name('broker-sales.show');
	Route::put('/broker-sales/{brokerSale}', 'BrokerSales\BrokerSalesController@update')->name('broker-sales.update');
	Route::delete('/broker-sales/{brokerSale}', 'BrokerSales\BrokerSalesController@destroy')->name('broker-sales.destroy');


	Route::resource('/conversations', 'Conversations\ConversationsController', ['except' => 'edit']);

	/**
	 * Conversation Subscribers Routes
	 */
	Route::get('/conversations/{conversation}/subscribers', 'Conversations\Subscribers\SubscribersController@index')->name('conversations.subscribers.index');
	Route::get('/conversations/{conversation}/subscribers/{subscriber}', 'Conversations\Subscribers\SubscribersController@show')->name('conversations.subscribers.show');

	/**
	 * Conversation Subscribers Routes
	 */
	Route::get('/conversations/{conversation}/reads/{subscriber}', 'Conversations\Reads\ReadsController@show')->name('conversations.reads.show');
	Route::put('/conversations/{conversation}/reads/{subscriber}', 'Conversations\Reads\ReadsController@update')->name('conversations.reads.update');

	/**
	 * Conversation Archive Routes
	 */
	Route::put('/conversations/{conversation}/archive', 'Conversations\Archive\ArchiveController@archive')->name('conversations.archive.archive');
	Route::put('/conversations/{conversation}/un-archive', 'Conversations\Archive\ArchiveController@unArchive')->name('conversations.archive.un-archive');

	/**
	 * Converstaion Message Routes
	 */
	Route::get('/conversations/{conversation}/messages', 'Conversations\Messages\MessagesController@index')->name('conversations.messages.index');
	Route::post('/conversations/{conversation}/messages', 'Conversations\Messages\MessagesController@store')->name('conversations.messages.store');
	Route::get('/conversations/{conversation}/messages/{message}', 'Conversations\Messages\MessagesController@show')->name('conversations.messages.show');
	Route::put('/conversations/{conversation}/messages/{message}', 'Conversations\Messages\MessagesController@update')->name('conversations.messages.update');
	Route::delete('/conversations/{conversation}/messages/{message}', 'Conversations\Messages\MessagesController@destroy')->name('conversations.messages.destroy');
});
