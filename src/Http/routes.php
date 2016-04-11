<?php

Route::group(['prefix' => config('admin.url')], function () {

    Route::group(['middleware' => ['auth.admin', 'auth.rules']], function () {
        Route::get('/maudit', ['uses' => 'MauditAdminController@index', 'as' => 'admin.maudit.index']);
    });

});