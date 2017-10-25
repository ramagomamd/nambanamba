<?php

namespace App\Http\Controllers\Backend\Music;

use App\Http\Controllers\Controller;
use App\Services\Music\Crawlers\Crawler;
use Illuminate\Support\Facades\DB;
use App\Repositories\Backend\Music\SingleRepository;
use App\Repositories\Backend\Music\AlbumRepository;

class CrawlersController extends Controller
{
	protected $crawler;
	protected $singles;
	protected $albums;

	public function __construct(Crawler $crawler, SingleRepository $singles, AlbumRepository $albums)
	{
		$this->crawler = $crawler;
		$this->singles = $singles;
		$this->albums = $albums;
	}

	public function index()
	{
		$this->crawler->retrieve();
		/*$singles = DB::table('singles_crawler')->latest('id');
		$albums = DB::table('albums_crawler')->latest('id');
		dd($albums);*/
		// Show All Crawlables, Albums; Singles & Tracks 
		// Distinguish between crawled and uncrawled
		// return view('backend.music.crawl', compact('singles', 'albums'));
	}

	public function singles()
	{/*
		DB::table('singles_crawler')->update(['crawled' => false]);
		DB::table('tracks_crawler')->update(['crawled' => false]);*/
		$singles = DB::table('singles_crawler')
					->where('singles_crawler.crawled', false)
					->join('tracks_crawler', 'crawlable_id', '=', 'singles_crawler.id')
					->where('crawlable_type', '=', 'singles')
					->where('tracks_crawler.crawled', false)
					->select('singles_crawler.*', 'tracks_crawler.*')
					->latest('singles_crawler.id')
					->take(-1)
					->get();
		$singles->each(function($single) {
			// dd($single);
			// dd(DB::table('tracks_crawler')->where('id', $single->id)->first());
			$this->singles->crawl((array) $single);
		});

		return back()->withFlashInfo("Finished Crawling Singles");
	}

	public function albums()
	{
		// $name = splitTitle("Jay Z - Magna Carta Holy Cow");
		// dd($name);
		$albums = DB::table('albums_crawler')
					->where('crawled', false)
					->latest('id')
					->take(-1)
					->get();
					// dd($albums);
		$albums->each(function($album) {
			$this->albums->crawl((array) $album);
			// dd(DB::table('tracks_crawler')->where('id', $albums['tracks_crawler']['id']));
		});

		return back()->withFlashInfo("Finished Crawling Albums");
	}

	public function crawl()
	{
		$results = $this->crawler->process(request()->all());

		return $results;
	}
}