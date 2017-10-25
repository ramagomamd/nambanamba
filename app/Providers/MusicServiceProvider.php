<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Settings;
use App\Services\Music\Tags;
use App\Services\Music\Download;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Music\Category\Category;
use App\Models\Music\Album\Album;
use App\Models\Music\Single\Single;
use App\Models\Music\Track\Track;

class MusicServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'albums' => Album::class,
            'singles' => Single::class,
            'tracks' => Track::class
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMusic();
        $this->registerTags();
        $this->registerDownload();
        $this->registerFacade();
    }

    /**
     * Register the application bindings.
     *
     * @return void
     */
    private function registerMusic()
    {
        $this->app->bind('settings', function ($app) {
            return new Settings($app);
        });
    }

    private function registerTags()
    {
        $this->app->bind('tags', function ($app) {
            return new Tags($app);
        });
    }

    private function registerDownload()
    {
        $this->app->bind('download', function ($app) {
            return new Download($app);
        });
    }

    /**
     * Register the vault facade without the user having to add it to the app.php file.
     *
     * @return void
     */
    public function registerFacade()
    {
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Settings', \App\Services\Facades\Settings::class);
        });

        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Tags', \App\Services\Music\Facades\Tags::class);
        });

        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Download', \App\Services\Music\Facades\Download::class);
        });
    }
}
