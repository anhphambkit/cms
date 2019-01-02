<?php

Route::group(['namespace' => 'Plugins\Cmsplugin\Http\Controllers', 'middleware' => 'web'], function () {

    Route::group(['prefix' => config('cms.admin_dir'), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'cmsplugin'], function () {

            Route::get('/', [
                'as' => 'cmsplugin.list',
                'uses' => 'CmspluginController@getList',
            ]);

            Route::get('/create', [
                'as' => 'cmsplugin.create',
                'uses' => 'CmspluginController@getCreate',
            ]);

            Route::post('/create', [
                'as' => 'cmsplugin.create',
                'uses' => 'CmspluginController@postCreate',
            ]);

            Route::get('/edit/{id}', [
                'as' => 'cmsplugin.edit',
                'uses' => 'CmspluginController@getEdit',
            ]);

            Route::post('/edit/{id}', [
                'as' => 'cmsplugin.edit',
                'uses' => 'CmspluginController@postEdit',
            ]);

            Route::get('/delete/{id}', [
                'as' => 'cmsplugin.delete',
                'uses' => 'CmspluginController@getDelete',
            ]);

            Route::post('/delete-many', [
                'as' => 'cmsplugin.delete.many',
                'uses' => 'CmspluginController@postDeleteMany',
                'permission' => 'cmsplugin.delete',
            ]);

            Route::post('/change-status', [
                'as' => 'cmsplugin.change.status',
                'uses' => 'CmspluginController@postChangeStatus',
                'permission' => 'cmsplugin.edit',
            ]);
        });
    });
    
});