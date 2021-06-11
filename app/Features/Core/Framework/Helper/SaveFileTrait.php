<?php

namespace App\Features\Core\Framework\Helper;

use Illuminate\Http\UploadedFile;
use League\Flysystem\Filesystem;

/**
 * Save file trait
 */
trait SaveFileTrait
{
    /**
     * Save the file into the server
     *
     * @param string $path
     * @param UploadedFile $file
     * @return string|null
     */
    private function saveFile(string $path, UploadedFile $file): ?string
    {
        // Get the file content
        $content = file_get_contents($file);

        // Get extension
        $extension = $file->getExtension();

        // Get full path
        $fullPath = "{$path}.{$extension}";

        // Save the file
        $response = app(Filesystem::class)->put($fullPath, $content);

        // Check if there is a error saving the file
        if (!$response) {
            return null;
        }

        // Return the full path
        return $fullPath;
    }
}
