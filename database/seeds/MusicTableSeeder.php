<?php

use Illuminate\Database\Seeder;
use App\Models\Music\Category\Category;
use App\Models\Music\Genre\Genre;
use Illuminate\Support\Facades\Cache;

/**
 * Class MusicTableSeeder.
 */
class MusicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cache::flush();
        $genres = [
            [
                'name'              => 'Hip Hop',
                'slug'              => str_slug('Hip Hop'),
            ],
        ];

        foreach ($genres as $genre) {
            Genre::forceCreate($genre);
        }

        $categories = [
            [
                'name'              => 'Mzansi',
                'slug'              => str_slug('Mzansi'),
            ],
            [
                'name'              => 'International',
                'slug'              => str_slug('International'),
            ],
        ];

        $genres = Genre::all();

        foreach ($categories as $category) {
            $category = Category::forceCreate($category);
            $category->genres()->attach($genres);
        }
    }
}
