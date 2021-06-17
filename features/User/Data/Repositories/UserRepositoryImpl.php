<?php

namespace Features\User\Data\Repositories;

use Features\Core\Framework\Base\BaseRepository;
use Features\User\Domain\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepositoryImpl extends BaseRepository implements UserRepository
{
    public function getModel(): Model
    {
        $model = User::class;
        return new $model;
    }

    public function getByEmail(string $email): ?User
    {
        return $this->newQuery()
            ->where('email', $email)
            ->first();
    }

    public function create(User $user): User
    {
        return $this->createOrUpdate($user->getAttributes());
    }
}
