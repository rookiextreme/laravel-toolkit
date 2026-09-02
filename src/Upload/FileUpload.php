<?php
namespace Rookiextreme\LaravelToolkit\Upload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUpload
{
    /**
     * @throws \Exception
     */
    public function uploadFileInApp(UploadedFile $file, string $folderPath, UploadOptions $options = new UploadOptions()) : array
    {
        $extension = $this->getExtension($file);
        $fileExtensionAllowed = $this->validateAllowedExtension($extension, $options->extensions);
        $this->validateFileSize($file, $options);

        if($fileExtensionAllowed)
        {
            $filename = $this->getSavedFileName($file->getClientOriginalName(), $options);
            $fileNameWithExtension = $filename.'.'.$extension;

            $this->checkAllowedDestination($options->destination);

            if($options->destination == 'public')
            {
                $fullPath = public_path($folderPath);
                $file->move($fullPath, $fileNameWithExtension);
            }else{
                Storage::disk($options->disk)->putFileAs($folderPath, $file, $fileNameWithExtension);
            }

            return [
                'path' => $folderPath,
                'name' => $fileNameWithExtension
            ];
        }

        throw new \Exception('File extension '.$extension.' not allowed');
    }

    public function validateFileSize(UploadedFile $file, UploadOptions $options): void
    {
        if ($options->maxSize > 0 && $file->getSize() > $options->maxSize) {
            throw new \Exception('File size exceeds maximum allowed size');
        }

        if ($options->minSize > 0 && $file->getSize() < $options->minSize) {
            throw new \Exception('File size is below minimum allowed size');
        }
    }

    public function getExtension(UploadedFile $file) : string
    {
        return $file->getClientOriginalExtension();
    }

    public function validateAllowedExtension(string $extension, array $allowedExtension) : bool
    {
        if(empty($allowedExtension))
        {
            throw new \Exception('Please provide extension allowed for this file');
        }

        return in_array($extension, $allowedExtension);
    }

    public function getSavedFileName(string $filename, UploadOptions $options) : string
    {
        $rand = random_int(10000,99999);
        $filename = str_replace(' ', '_', $filename);

        if(!$options->useOriginalName && !$options->useRandomIntName && $options->useOriginalNameUnique)
        {
            return $filename.'_'.$rand;
        }else if(!$options->useOriginalName && $options->useRandomIntName && !$options->useOriginalNameUnique)
        {
            return $rand;
        }

        return $filename;
    }

    /**
     * @throws \Exception
     */
    public function checkAllowedDestination(string $storage): void
    {
        if(!in_array($storage, ['public', 'storage']))
        {
            throw new \Exception('Destination not allowed');
        }
    }
}