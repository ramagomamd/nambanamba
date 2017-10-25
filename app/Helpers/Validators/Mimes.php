<?php

namespace App\Helpers\Validators;

use League\Flysystem\Util\MimeType;
use getID3;
use getid3_lib;
use getid3_id3v2;

/**
 * Class Mimes.
 */
class Mimes
{
    public function audio($file)
    {
        $mime_types = collect([
                'audio/aac',
                'audio/ogg',
                'audio/mpeg',
                'audio/mp3',
                'audio/mpeg',
                'audio/wav'
            ]);

        $file_mime = $mime_types->contains($file->getMimeType());
        $client_mime = $mime_types->contains($file->getClientMimeType());
        $guessed_mime = $mime_types->contains(MimeType::detectByFilename($file->getRealPath()));
        $getID3_mime = $mime_types->contains($this->getID3MimeType($file->getRealPath()));

        // dd($file_mime);
        // dd($client_mime);
        // dd($guessed_mime);
        // dd($getID3_mime);

        if ($file_mime || $client_mime || $guessed_mime || $getID3_mime) {
            return true;
        }
        return false;
    }

    public function image($file)
    {
        $extensions = collect([
                'jpg',
                'jpeg',
                'png',
                'gif',
        ]);

        $extension = $file->extension();

        if ($extensions->contains($extension)) {
            return true;
        }
        return false;
    }

    public function getID3MimeType($filename) {
        // $filename = realpath($filename);
        if (!file_exists($filename)) {
            // echo 'File does not exist: "'.htmlentities($filename).'"<br>';
            return;
        } elseif (!is_readable($filename)) {
            // echo 'File is not readable: "'.htmlentities($filename).'"<br>';
            return;
        }
        // Initialize getID3 engine
        $getID3 = new getID3;

        $determinedMimeType = '';
        if ($fp = fopen($filename, 'rb')) {
            $getID3->openfile($filename);
            if (empty($getID3->info['error'])) {

                // ID3v2 is the only tag format that might be prepended in front of files, and it's non-trivial to skip, easier just to parse it and know where to skip to
                getid3_lib::IncludeDependency(GETID3_INCLUDEPATH.'module.tag.id3v2.php', __FILE__, true);
                $getid3_id3v2 = new getid3_id3v2($getID3);
                $getid3_id3v2->Analyze();

                fseek($fp, $getID3->info['avdataoffset'], SEEK_SET);
                $formattest = fread($fp, 16);  // 16 bytes is sufficient for any format except ISO CD-image
                fclose($fp);

                $DeterminedFormatInfo = $getID3->GetFileFormat($formattest);
                $determinedMimeType = $DeterminedFormatInfo['mime_type'];

            } else {
                return;
                // echo 'Failed to getID3->openfile "'.htmlentities($filename).'"<br>';
            }
        } else {
            return;
            // echo 'Failed to fopen "'.htmlentities($filename).'"<br>';
        }
        return $determinedMimeType;
    }
}
