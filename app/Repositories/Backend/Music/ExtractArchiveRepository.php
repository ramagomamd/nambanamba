<?php

namespace App\Repositories\Backend\Music;

use ZipArchive;
use Symfony\Component\Finder\Finder;
use Spatie\TemporaryDirectory\TemporaryDirectory;
use App\Exceptions\GeneralException;

class ExtractArchiveRepository
{
    /**
     * @var ZipArchive
     */
    protected $archive;

    protected $directory;

    protected $path;

    /**
     * @param string $path
     *
     * @throws GeneralException
     */
    public function __construct($path)
    {
        if (!class_exists('ZipArchive')) {
            throw new GeneralException('Extracting files requires ZipArchive module.');
        }

        $this->path = $path;
        
        $this->directory = (new TemporaryDirectory())->create();

        $this->archive = new ZipArchive();

        if ($this->archive->open($this->path) !== true) {
            throw new GeneralException('Cannot open zip file.');
        }
    }

    public function extract()   
    {
        $destination = $this->directory->path() . "/";
        for($i = 0; $i < $this->archive->numFiles; $i++) {
            $filename = $this->archive->getNameIndex($i);
            $fileinfo = pathinfo($filename);
            copy("zip://".$this->path."#".$filename, $destination.$fileinfo['basename']);
        }
        $this->finish();  

        return $this->gatherFiles($destination);
    }

    /**
     * Gather all applicable files in a given directory.
     *
     * @param string $path The directory's full path
     *
     * @return array An array of SplFileInfo objects
     */
    public function gatherFiles($path)
    {
        return iterator_to_array(
            Finder::create()
                ->ignoreUnreadableDirs()
                ->ignoreDotFiles(true) // https://github.com/phanan/koel/issues/450
                ->files()
                ->followLinks()
                ->in($path)
        );
    }

    /**
     * Finish (close) the archive.
     *
     * @return $this
     */
    public function finish()
    {
        $this->archive->close();

        return $this;
    }
}
