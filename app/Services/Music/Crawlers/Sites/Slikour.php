<?php

namespace App\Services\Music\Crawlers\Sites;

use Illuminate\Support\Facades\DB;

class Slikour 
{
	public static function scan($client, $data)
	{
		$crawler = $client->request('GET', $data['url']);
		// dd($crawler);
		// If we are moving to another page then click the paging link:
		// Use a CSS filter to select only the result links:
		$results[] = $crawler->filter('.panel.panel-media.shadow-panel')
			->each(function ($result) use ($client, $data) {
			$url = "https://www.slikouronlife.co.za";
			$cover = trim($result->filter('.panel-heading img')->first()->attr('src'));
			$artist = trim($result->filter('h3.media-name a')->first()->text());
			$full_title = $artist . " - " . trim($result->filter('h3.media-description a')->first()->text());
			$singlelink = $url . trim($result->filter('h3.media-description a')->first()->attr('href'));
			$mp3link = $url . trim($result->filter('a[href*="download-song"]')->first()->attr('href'));
			// dd($mp3link);

			try {
				$single = DB::table('singles_crawler')
							->insertGetId([
								'title' => $full_title,
								'link' => $singlelink,
								'site_name' => 'slikouronlife',
								'cover' => $cover,
								'category' => $data['category'],
								'genre' => $data['genre']
							]);
				// dd($single);
				// Store  the mp3 to singles database
				$track = DB::table('tracks_crawler')->insertGetId([
					'link' => $mp3link,
					'crawlable_id' =>  $single,
					'crawlable_type' => 'singles',
				]);
			} catch (\Exception $e) {
				return;
			}
			
			$result = "A single with Link {$full_title} was saved";

			return $result;
		});
		// dd(array_sum($result));
		return $results;
	}
}