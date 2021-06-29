<?php
namespace Features\Envelope\Domain\Usecases;

use Features\Envelope\Domain\Repositories\EnvelopeRepository;

class RemoveEnvelopeUseCase
{
    private EnvelopeRepository $repository;

    public function __construct(EnvelopeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $envelopeId): bool
    {
        return $this->repository->remove($envelopeId);
    }
}
