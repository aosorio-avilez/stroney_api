<?php
namespace Features\Envelope\Data\Repositories;

use App\Models\Envelope;
use Features\Core\Framework\Base\BaseRepository;
use Features\Envelope\Domain\Repositories\EnvelopeRepository;
use Illuminate\Database\Eloquent\Model;

class EnvelopeRepositoryImpl extends BaseRepository implements EnvelopeRepository
{
    public function getModel(): Model
    {
        $model = Envelope::class;
        return new $model;
    }

    public function create(Envelope $envelope): Envelope
    {
        return $this->createOrUpdate($envelope->getAttributes());
    }

    public function update(string $envelopeId, Envelope $envelope): Envelope
    {
        return $this->createOrUpdate($envelope->getAttributes(), [
            'id' => $envelopeId
        ]);
    }

    public function getById(string $envelopeId): ?Envelope
    {
        return $this->newQuery()
            ->where('id', $envelopeId)
            ->first();
    }
}
