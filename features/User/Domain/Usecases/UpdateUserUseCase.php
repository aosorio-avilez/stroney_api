<?php

namespace Features\User\Domain\Usecases;

use Features\User\Domain\Failures\UserNotFound;
use Features\User\Domain\Repositories\UserRepository;
use App\Models\User;
use Features\Core\Framework\Helper\FileHelper;
use Features\Core\Framework\Helper\WithFileStorage;
use Illuminate\Http\UploadedFile;

class UpdateUserUseCase
{
    use WithFileStorage;
    
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(User $user, ?UploadedFile $file): User
    {
        if ($file != null) {
            $user->image_file_name = FileHelper::getRandomFileName($file);
            $this->saveFile($user->image_file_name, $file);
            $user->image_url = $this->getFileUrl($user->image_file_name);
        }

        return $this->repository->update($user->id, $user);
    }
}
