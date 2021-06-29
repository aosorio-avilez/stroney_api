<?php
namespace Features\Envelope\Domain\Repositories;

use App\Models\Envelope;

interface EnvelopeRepository
{
    public function create(Envelope $envelope): Envelope;
}
