<?php
namespace Features\Envelope\Domain\Usecases;

use Features\Envelope\Domain\Repositories\EnvelopeRepository;

class GetEnvelopesByUserUseCase
{
    private EnvelopeRepository $repository;

    public function __construct(EnvelopeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $userId): array
    {
        return $this->repository->getByUser($userId)->all();
    }
}
