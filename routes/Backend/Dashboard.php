<?php

/**
 * All route names are prefixed with 'admin.'.
 */
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('dashboard/refresh-all-cache', 'DashboardController@refreshAllCache')->name('refresh-all-cache');

// Settings
Route::group([
    'as'     => 'settings.',
    'prefix' => 'settings',
], function () {
    Route::get('/', ['uses' => 'SettingsController@index',        'as' => 'index']);
    Route::post('/', ['uses' => 'SettingsController@store',        'as' => 'store']);
    Route::put('/', ['uses' => 'SettingsController@update',       'as' => 'update']);
    Route::delete('{setting}', ['uses' => 'SettingsController@destroy',       'as' => 'destroy']);
    Route::get('{setting}/move_up', ['uses' => 'SettingsController@move_up',      'as' => 'move_up']);
    Route::get('{setting}/move_down', ['uses' => 'SettingsController@move_down',    'as' => 'move_down']);
    Route::get('{setting}/delete_value', ['uses' => 'SettingsController@delete_value', 'as' => 'delete_value']);
});
