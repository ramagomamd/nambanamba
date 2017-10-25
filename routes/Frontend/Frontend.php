<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', 'FrontendController@index')->name('index');
Route::get('macros', 'FrontendController@macros')->name('macros');
Route::get('contact', 'ContactController@index')->name('contact');
Route::post('contact/send', 'ContactController@send')->name('contact.send');

Route::get('/search', 'SearchController@search')->name('search');

Route::group(['prefix' => 'crawls'], function () {
    Route::get('albums/songslover', function () {
        return view('frontend.music.crawls.songslover-albums');
    });
});

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 */
Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        /*
         * User Dashboard Specific
         */
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        /*
         * User Account Specific
         */
        Route::get('account', 'AccountController@index')->name('account');

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', 'ProfileController@update')->name('profile.update');
    });
});

/*
 * All route names are prefixed with 'frontend.'.
 * Music Routes
 */
Route::group([
    'as' => 'music.',
    'namespace' => 'Music'
], function () {
    // Route::get('/categories', 'CategoriesController@index')->name('categories.index');
    Route::resource('artists', 'ArtistsController', ['only' => ['index', 'show']]);
    Route::resource('tracks', 'TracksController', ['only' => 'index']);
    Route::resource('genres', 'GenresController', ['only' => ['index', 'show']]);
    Route::resource('albums', 'AlbumsController', ['only' => 'index']);
    Route::resource('singles', 'SinglesController', ['only' => 'index']);
    Route::get('{category}', 'CategoriesController@show')
        ->name('categories.show'); 

    Route::get('{category}/albums', 'CategoriesController@albums')
        ->name('categories.albums');

    Route::get('{category}/singles', 'CategoriesController@singles')
        ->name('categories.singles');
        
    Route::get('{category}/{genre}', 'CategoriesGenresController@index')
        ->name('categories.genres');

    Route::get('genres/{genre}/singles', 'GenresController@singles')->name('genres.singles');
    Route::get('genres/{genre}/albums', 'GenresController@albums')->name('genres.albums');

    Route::get('artists/{artist}/albums', 'ArtistsController@albums')->name('artists.albums');
    Route::get('artists/{artist}/singles', 'ArtistsController@singles')->name('artists.singles');
    Route::get('artists/{artist}/tracks', 'ArtistsController@tracks')->name('artists.tracks');

    Route::get('{category}/{genre}/albums', 'CategoriesGenresController@getAlbums')
        ->name('categories.genres.albums');

    Route::get('{category}/{genre}/singles', 'CategoriesGenresController@getSingles')
        ->name('categories.genres.singles');

    Route::get('{category}/{genre}/{trackableType}/{trackableSlug}/{track}', 'TracksController@show')
        ->name('tracks.show');

    Route::get('{category}/{genre}/albums/{album}', 'AlbumsController@show')
        ->name('albums.show');  
});
