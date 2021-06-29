<?php
namespace Features\Envelope\Domain\Usecases;

use App\Models\Envelope;
use Features\Envelope\Domain\Repositories\EnvelopeRepository;

class UpdateEnvelopeUseCase
{
    private EnvelopeRepository $repository;

    public function __construct(EnvelopeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $envelopeId, Envelope $envelope): Envelope
    {
        return $this->repository->update($envelopeId, $envelope);
    }
}
