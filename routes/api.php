<?php
Route::group(['prefix' => 'v1'], function() {
    Route::get('users', 'Api\v1\UserController@index')->name('api.v1.users.index');
});
