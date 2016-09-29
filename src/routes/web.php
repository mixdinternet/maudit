<?php

Route::group(['middleware' => ['web'], 'prefix' => config('admin.url')], function () {
    Route::group(['middleware' => ['auth.admin', 'auth.rules']], function () {
        Route::get('/maudit', ['uses' => 'MauditController@index', 'as' => 'admin.maudit.index']);
    });
});