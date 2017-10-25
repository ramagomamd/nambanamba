<?php

/**
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', 'LanguageController@swap');

Route::get('goute', function() {
	// Create a new Goutte client instance
	$client = new \Goutte\Client();
	// Hackery to allow HTTPS
	$guzzleclient = new \GuzzleHttp\Client([
	'timeout' => 60,
	'verify' => false,
	]);
	// Hackery to allow HTTPS
	$client->setClient($guzzleclient);
	
	$crawler = $client->request('GET', 'http://lulamusic.dev/albums');
	$albums = $crawler->filter('div.media-body strong a')->each(function ($node) {
		return $node->attr('href');
	});
	// dd($links);
	foreach($albums as $album) {
		$crawler = $client->request('GET', $album);
		// dd($crawler);
		$title = $crawler->filter('.row strong a')->eq(2)->text();
		dd($title);
		// dd(trim($link));
		$link = $crawler->selectLink(trim($link))->link();
		// dd($link);
		// dd($client);
		$crawler = $client->click($link);
		// dd($crawler->getUri());
		$crawler->filter('*')->each(function($node) {
			echo  $node->text()  . "<br>";
		});
	}
});


/* ----------------------------------------------------------------------- */

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */
    includeRouteFiles(__DIR__.'/Backend/');
});

/* ----------------------------------------------------------------------- */

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    includeRouteFiles(__DIR__.'/Frontend/');
});
