<?php
namespace Features\Envelope\Domain\Usecases;

use App\Models\Envelope;
use Features\Envelope\Domain\Failures\EnvelopeNotFound;
use Features\Envelope\Domain\Repositories\EnvelopeRepository;

class GetEnvelopeUseCase
{
    private EnvelopeRepository $repository;

    public function __construct(EnvelopeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $envelopeId): Envelope
    {
        $envelope = $this->repository->getById($envelopeId);

        if ($envelope == null) {
            throw new EnvelopeNotFound();
        }

        return $envelope;
    }
}
