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

    public function handle(string $userId, User $user, ?UploadedFile $file): User
    {
        $currenUser = $this->repository->getById($userId);

        if ($currenUser == null) {
            throw new UserNotFound();
        }
        
        if ($file != null) {
            $user->image_file_name = FileHelper::getRandomFileName($file);
            $this->saveFile($user->image_file_name, $file);
            $user->image_url = $this->getFileUrl($user->image_file_name);
        }

        return $this->repository->update($userId, $user);
    }
}
