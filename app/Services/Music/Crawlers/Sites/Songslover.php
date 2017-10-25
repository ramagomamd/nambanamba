<?php

namespace App\Services\Music\Crawlers\Sites;

use Illuminate\Support\Facades\DB;

class Songslover 
{
	public static function scan($client, $data)
	{
		$crawler = $client->request('GET', $data['url']);
		// dd($crawler);
		$results[] = $crawler->filter('article.item-list')->each(function ($result) use ($client, $data)  {
			$crawler = $client->request('GET', $result->attr('href'));
			$mp3s = $crawler->filter('a[href$=".mp3"]')->each(function ($mp3, $index) {
				if ($index % 2 === 0) {
					return $mp3->attr('href');
				}
			});

			$mp3s = collect($mp3s)->reject(null);

			if ($mp3s->isNotEmpty()) {
				$link = $result->attr('href');
				try{
				    $title = $crawler->filter('h1.story-title')->first()->text();
				} catch(\Exception $e) { 
				    // Node list is empty
				    $title = null;
				}
				try{
				    $cover = $crawler->filter('div > p > img.aligncenter')->first()->attr('src');
				} catch(\Exception $e) { 
				    // Node list is empty
				    $cover = null;
				}
				
				if ($mp3s->count() == 1 && !is_null($title)) {
					$single = DB::table('singles_crawler')
								->insertGetId([
									'title' => $title,
									'link' => $link,
									'site_name' => 'songslover',
									'cover' => $cover,
									'category' => $data['category'],
									'genre' => $data['genre']
								]);
					// dd($single);
					// Store  the mp3 to singles database
					$track = DB::table('tracks_crawler')->insertGetId([
						'link' => $mp3s->first(),
						'crawlable_id' =>  $single,
						'crawlable_type' => 'singles',
					]);
					$result = "A single with Link {$title} was saved";
				} elseif ($mp3s->count() > 1 && !is_null($title)) {
						$album = DB::table('albums_crawler')
								->insertGetId([
									'title' => $title,
									'link' => $link,
									'site_name' => 'songslover',
									'cover' => $cover,
									'category' => $data['category'],
									'genre' => $data['genre']
								]);
					// dd($single);
					// Store  the mp3 to singles database
					$mp3s->each(function($mp3) use ($album) {
						$track = DB::table('tracks_crawler')->insertGetId([
							'link' => $mp3,
							'crawlable_id' =>  $album,
							'crawlable_type' => 'singles',
						]);
					});
					$result = "A single with Link {$title} was saved";
				}
			} else {
				$result  = "Nothing was  saved";
			}

			return $result;
		});

		return $results;
	}
}