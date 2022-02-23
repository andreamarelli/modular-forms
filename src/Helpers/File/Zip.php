<?php


namespace AndreaMarelli\ModularForms\Helpers\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use AndreaMarelli\ModularForms\Models\Traits\Upload;

class Zip
{
    /**
     * retrieve zip file from temp folder open it and extract files
     * @param string $zip_path
     * @param string $unzip_path
     * @param boolean $remove_zip
     * @return array
     */
    public static function extract(string $zip_path, $unzip_path, $remove_zip = true): array
    {
        $unzip_path = $unzip_path ?? dirname($zip_path);
        $relative_path = Str::replace(Storage::path(''), '', $unzip_path);

        // Read ZIP archive and extract files
        $zip = new ZipArchive;
        $zipStatus = $zip->open($zip_path);
        if ($zipStatus !== true) {
            throw new Exception('Unable to extract the archive.');
        }
        $zip->extractTo($unzip_path);
        $zip->close();

        // Read extracted files' paths
        $files = [];
        foreach(Storage::files($relative_path) as $file){
            $files[] = Storage::path($file);
        }

        // Remove source ZIP archive
        if($remove_zip){
            unlink($zip_path);
        }

        return $files;
    }


    /**
     * pass an array of files to add them in a zip
     * @param array $files
     * @param string $zip_path
     * @param bool $remove_files
     * @return string
     */
    public static function compress(array $files, string $zip_path, bool $remove_files = true) : string
    {
        $zip_path = $zip_path===basename($zip_path)
            ? Storage::disk(File::TEMP_STORAGE)->path('') . $zip_path
            : $zip_path;

        // Create ZIP and add files
        $zip = new ZipArchive();
        $zip->open($zip_path, \ZipArchive::CREATE);
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();

        // Remove source files
        if ($remove_files) {
            foreach ($files as $file) {
                unlink($file);
            }
        }

        return $zip_path;
    }
}
