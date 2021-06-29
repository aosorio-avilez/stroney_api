<?php
namespace Features\Envelope\Domain\Repositories;

use App\Models\Envelope;

interface EnvelopeRepository
{
    public function create(Envelope $envelope): Envelope;

    public function update(string $envelopeId, Envelope $envelope): Envelope;

    public function getById(string $envelopeId): ?Envelope;

    public function remove(string $envelopeId): bool;
}
