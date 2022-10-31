<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum','web']], function () {
    // Users
    Route::apiResource('users', 'UsersApiController');

    // Allwallettransactions
    Route::apiResource('allwallettransactions', 'AllwallettransactionsApiController');

    // Bots
    Route::apiResource('bots', 'BotsApiController');
    Route::post('/bots/create', 'BotsApiController@create');
    Route::get('/user/balance/{exchange}/{symbol}', 'BotsApiController@userBalance');
    Route::get('/bot/{bot_id}/trades/{total_records}','TradesApiController@index');

    // Sessions
    Route::apiResource('sessions', 'SessionsApiController', ['except' => ['store', 'show', 'update', 'destroy']]);

    // Trades
    Route::apiResource('trades', 'TradesApiController');

    Route::get('/bot/{bot_id}/stats', 'BotsApiController@botStats');
    Route::get('/bot/{bot_id}/delete', 'BotsApiController@botDelete');
    // Covers
    Route::apiResource('covers', 'CoversApiController', ['except' => ['show']]);
    Route::get('/autocomplete-name', 'UsersApiController@autocompleteName');

});
Route::post('migrate/database', 'Api\V1\Admin\PuxeoController@migrateDatabase');
Route::post('seed/permission', 'Api\V1\Admin\PuxeoController@seedPermission');
Route::post('webhook/nowpayment', 'Api\V1\Admin\AllwallettransactionsApiController@nowPayment')->name('webhook.nowpayment');//->middleware('auth:sanctum','web')
Route::post('/validate-platform-key', 'Api\V1\Admin\LicenseApiController@validatePlatformKey')->name('validatePlatformKey');
Route::post('/validate-bot-key', 'Api\V1\Admin\LicenseApiController@validateBotKey')->name('validateBotKey');
Route::post('/get-bot-count', 'Api\V1\Admin\LicenseApiController@BotCount')->name('GetBotCount');
Route::post('/getUser', 'Api\V1\Admin\UsersApiController@getUser')->name('getUser');
Route::post('/platform-upgrade', 'Api\V1\Admin\LicenseApiController@platformUpgrade')->name('PlatformUpgrade');
