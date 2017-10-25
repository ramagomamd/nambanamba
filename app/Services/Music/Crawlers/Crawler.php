<?php

namespace App\Services\Music\Crawlers;

use Goutte\Client;
use GuzzleHttp\Client as Guzzle;
use App\Services\Music\Crawlers\Sites\Fakaza;
use App\Services\Music\Crawlers\Sites\Slikour;
use App\Services\Music\Crawlers\Sites\Songslover;
use App\Services\Music\Crawlers\Sites\Lulamusic;

class Crawler
{

	public function process(array $data)
	{
		$client = new Client();
		$guzzle = new Guzzle([
			'timeout' => 60,
			'verify' => false,
		]);
		$client->setClient($guzzle);

		// $crawler = $client->request('GET', $data['url']);
		// dd($crawler);

		switch($data['site']) {
			case "lulamusic":
				$results = Lulamusic::scan($client, $data);
				break;
			case "slikour":
				$results = Slikour::scan($client, $data);
				break;
			case "fakaza":
				$results = Fakaza::scan($client, $data);
				break;
			case "songslover":
				$results = Songslover::scan($client, $data);
				break;
		}

		return $results;
	}

	public function retrieve()
	{
		$client = new Guzzle([
			'timeout' => 60,
			'verify' => false,
		]);

		$response = $client->get('https://api.agenty.com/v1/output/1ea6f53192', [
			'headers' => [
				'content-type' => 'application/json',
				'x-datascraping-api-key' => 'd176a3f80159ba5026ce40078d0202fa',
				'x-datascraping-api-id' => 'A21K30E1V8'
			],
			'query' => [
				'offset' => '0', 'limit' => '1000'
			]
		]);
		// dd($response);
		// $request->setMethod(HTTP_METH_GET);

		/*$request->setQueryData(array(
		  'offset' => '0',
		  'limit' => '1000'
		));*/

		/*$request->setHeaders(array(
		  'content-type' => 'application/json',
		  'x-datascraping-api-key' => 'd176a3f80159ba5026ce40078d0202fa',
		  'x-datascraping-api-id' => 'A21K30E1V8'
		));*/
		dd($response->getBody());
	}
}