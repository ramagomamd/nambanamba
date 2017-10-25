<?php

namespace App\Services\Music;

use App\Models\Music\Album\Album;
use App\Models\Music\Artist\Artist;
use App\Models\Music\Track\Track;
use App\Repositories\Backend\Music\ZipArchiveRepository;
use App\Exceptions\GeneralException;
use Illuminate\Support\Collection;
use SplFileInfo;

class Download
{
    /**
     * Generic method to generate a download archive from various source types.
     *
     * @param Track|Collection<Track>|Album|Artist $mixed
     *
     * @throws GeneralException
     *
     * @return string Full path to the generated archive
     */
    public function from($mixed)
    {
        if ($mixed instanceof Track) {
            return $this->fromTrack($mixed);
        } elseif ($mixed instanceof Collection) {
            return $this->fromMultipleTracks($mixed);
        } elseif ($mixed instanceof Album) {
            return $this->fromAlbum($mixed);
        } elseif ($mixed instanceof Artist) {
            return $this->fromArtist($mixed);
        } else {
            throw new GeneralException('Unsupport download type.');
        }
    }

    /**
     * Generate the downloadable path for a song.
     *
     * @param Song $song
     *
     * @return string
     */
    public function fromTrack(Track $track)
    {
        $path = $track->path instanceof SplFileInfo ? $track->path : new SplFileInfo($track->path);
        // The Track is hosted locally. Make sure the file exists.
        abort_unless(file_exists($path), 404);
        $localPath = $path;

        // The BinaryFileResponse factory only accept ASCII-only file names.
        if (ctype_print($localPath)) {
            return $localPath;
        }

        // For those with high-byte characters in names, we copy it into a safe name
        // as a workaround.
        $newPath = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.utf8_decode(basename($path));

        
        // Else we copy it to another file to not mess up the original one.
        copy($localPath, $newPath);

        return $newPath;
    }

    /**
     * Generate a downloadable path of multiple tracks in zip format.
     *
     * @param Collection $tracks
     *
     * @throws Exception
     *
     * @return string
     */
    protected function fromMultipleTracks(Collection $tracks)
    {
        if ($tracks->count() === 1) {
            return $this->fromTrack($tracks->first());
        }

        return (new ZipArchiveRepository())
            ->addFiles($tracks)
            ->finish()
            ->getPath();
    }

    protected function fromAlbum(Album $album)
    {
        return $this->fromMultipleTracks($album->tracks);
    }

}
