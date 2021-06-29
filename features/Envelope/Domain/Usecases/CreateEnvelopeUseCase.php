<?php
namespace Features\Envelope\Domain\Usecases;

use App\Models\Envelope;
use Features\Envelope\Domain\Repositories\EnvelopeRepository;

class CreateEnvelopeUseCase
{
    private EnvelopeRepository $repository;

    public function __construct(EnvelopeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $userId, Envelope $envelope): Envelope
    {
        $envelope->user_id = $userId;
        return $this->repository->create($envelope);
    }
}
