<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Collection;
use App\Models\Music\Album\Album;
use App\Models\Music\Category\Category;
use App\Models\Music\Genre\Genre;
use App\Repositories\Backend\Music\AlbumRepository;
use Illuminate\Database\Eloquent\Model;
use Exception;

class ZipAlbums extends Command
{
    use ConfirmableTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'albums:generate-zip {category?} {genre?} {--ids=*}
    {-- force : Force the operation to run when in production}
    {--overwrite : Wether to overwrite already archived albums}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Zip Albums By Category, Genre, Category & Genre or by ID With atleast Two Tracks';

    protected $albums;

    /** @var array */
    protected $erroredAlbumIds = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(AlbumRepository $albums)
    {
        parent::__construct();
        $this->albums = $albums;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $overwrite = $this->option('overwrite');
        $albums = $this->getAlbumToBeRegenerated();

        if (!is_null($albums)) {
            $albums = $albums->reject(function (Album $album) {
                return ! $album->tracks->count() > 1;
            });
        } 
        if (is_null($albums) || $albums->isEmpty()) {
            $albums = null;
            $this->warn("\nNo Album could be found to zip from the provided info");
        }

        if ($albums) {
            $progressBar = $this->output->createProgressBar($albums->count());

            $this->errorMessages = [];

            $albums->each(function (Album $album) use ($progressBar, $overwrite) {
                try {
                    if (!$overwrite) {
                        if (!is_null($album->zip)) {
                            $this->warn("\n{$album->full_title} Already Zipped");
                        } else {
                            $this->albums->createZip($album);
                            $this->info("\n{$album->full_title} Successfully Zipped");
                        }
                    } else {
                        $this->albums->createZip($album);
                        $this->info("\n{$album->full_title} Successfully Zipped");
                    }
                } catch (Exception $exception) {
                    $this->errorMessages[$album->id] = $exception->getMessage();
                }

                $progressBar->advance();
            });

            $progressBar->finish();

            if (count($this->errorMessages)) {
                $this->warn("\nAll done, but with some error messages");

                foreach ($this->errorMessages as $albumId => $message) {
                    $this->warn("\nAlbum id {$albumId}: `{$message}`");
                }
            }
        }

        $this->info("\nAll done!");
    }

    public function getAlbumToBeRegenerated()
    {
        $category = $this->argument('category') ?? '';
        $genre = $this->argument('genre') ?? '';
        $albumIds = $this->option('ids');

        if ($category !== '') {
            $category = Category::similarSlug(str_slug($category))->first();
            if (!isset($category)) {
                $category =  '';
                $this->error("\nProvided Category Not Found!, Cancelling command");
                return null;
            }
        }

        if ($genre !== '') {
            $genre = Genre::similarSlug(str_slug($genre))->first();
            if (!isset($genre)) {
                $genre =  '';
                $this->error("\nProvided Genre Not Found!, Cancelling command");
                return null;
            }
        }

        if ($category === '' && $genre === '' && ! $albumIds) {
            return Album::whereHas('tracks')->get();
        }

        if ($category && $genre === '' && ! $albumIds) {
            return Album::byCategory($category)->whereHas('tracks')->get();
        }

        if ($category === '' && $genre && ! $albumIds) {
            return Album::byGenre($genre)->whereHas('tracks')->get();
        }

        if ($category && $genre && ! $albumIds) {
            return Album::byCategoryAndGenre($category, $genre)->whereHas('tracks')->get();
        }

        if ($albumIds) {
            if (! is_array($albumIds)) {
                $albumIds = explode(',', $albumIds);
            }

            return Album::find($albumIds);
        }

        return null;
    }
}
