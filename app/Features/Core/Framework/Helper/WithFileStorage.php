<?php

namespace App\Features\Core\Framework\Helper;

use App\Features\Core\Domain\Failure\DeleteFileFailure;
use App\Features\Core\Domain\Failure\SaveFileFailure;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait WithFileStorage
{
    /**
     * Save file on default storage
     *
     * @param string $path
     * @param UploadedFile $file
     * @return void
     * @throws SaveFileFailure in case that the file could not save
     */
    public function saveFile(string $path, UploadedFile $file)
    {
        if (!Storage::put($path, file_get_contents($file))) {
            throw new SaveFileFailure(__('Save file error'), 500, 'save_file_error');
        }
    }

    /**
     * Delete file from default storage
     *
     * @param string|null $path
     * @return void
     * @throws DeleteFileFailure in case that the file could not delete
     */
    public function deleteFile(?string $path)
    {
        if (Storage::exists($path)) {
            if (!Storage::delete($path)) {
                throw new DeleteFileFailure(__('Delete file error'), 500, 'delete_file_error');
            }
        }
    }

    /**
     * Get full image url
     *
     * @param string $path
     * @return string
     */
    public function getFileUrl(string $path) : string
    {
        return Storage::url($path);
    }
}
