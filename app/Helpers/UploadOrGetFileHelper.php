<?php
namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App;

class UploadOrGetFileHelper
{
    /**
     * $file = $request->file('fileName');
     * 
     * @param  file $file The file we want to save
     * @param  string $fileFolder The file type we want to save
     * @return string $filePath Path in which the file was saved in
     */
    public static function saveFile($file, string $fileFolder)
    {
        // Define folder path
        $folder = '/public/'.$fileFolder;
        // Make a file path where file will be stored
        $filePath = $folder;
        // Upload file
        $environment = App::environment();
        if ($environment === 'production') {
            $filePath = UploadOrGetFileHelper::uploadFileToS3($file, $filePath);
            return $filePath;
        } else {
            $filePath = UploadOrGetFileHelper::uploadFileToLocalStorage($file, $filePath);
            //Example PHP string.

            //Get the first occurrence of a character.
            $strpos = strpos($filePath, '/');

            //Get the second half of the string
            $res = substr($filePath, ($strpos));

            return $res;
        }

        return null;
    }

    public static function uploadFileToLocalStorage($uploadedFile, $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $path = $uploadedFile->store($name);

        return $path;
    }

    public static function uploadFileToS3($uploadedFile, $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $path = $uploadedFile->store($name, 's3');

        return $path;
    }

    public static function deleteFile($filepath)
    {
        $environment = App::environment();

        if ($environment === 'production') {
            if(Storage::disk('s3')->exists($filepath)) {
                Storage::disk('s3')->delete($filepath);
            }
        } else {
            if(Storage::exists('public'.$filepath)) {
                Storage::delete('public'.$filepath);
            }
        }
    }

    public  static function getFile(string $filePath) 
    {
        $environment = App::environment();

        if ($environment === 'production') {
            $s3 = Storage::disk('s3');
            $client = $s3->getDriver()->getAdapter()->getClient();
            $expiry = "+10 minutes";

            $command = $client->getCommand('GetObject', [
                'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
                'Key'    => $filePath
            ]);

            $request = $client->createPresignedRequest($command, $expiry);

            return (string) $request->getUri();
        }

        return url('storage'.$filePath);
        // 
        // return Storage::url('storage/'.$filePath);
    }
}