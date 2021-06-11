<?php

namespace App\Features\Core\Framework\Helper;

use Faker\Provider\Uuid;
use Illuminate\Http\UploadedFile;

class FileHelper
{
    /**
     * Gte the file extension
     *
     * @param UploadedFile $file
     * @return string
     */
    public static function getExtension($file)
    {
        return explode('/', $file->getMimeType())[1];
    }

    public static function getRandomFileName(?UploadedFile $file): ?string
    {
        return $file != null ? Uuid::uuid() . '.' . $file->extension() : null;
    }
}
