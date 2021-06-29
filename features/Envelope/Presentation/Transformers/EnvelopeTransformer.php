<?php
namespace Features\Envelope\Presentation\Transformers;

use App\Models\Envelope;
use Features\Core\Framework\Transformer\FractalTransformer;
use League\Fractal\TransformerAbstract;

class EnvelopeTransformer extends TransformerAbstract
{
    private FractalTransformer $fractal;

    public function __construct(
        FractalTransformer $fractal
    ) {
        $this->fractal = $fractal;
    }

    public function transform(Envelope $envelope)
    {
        return [
            'id' => $envelope->id,
            'name' => $envelope->name,
            'amount' => $envelope->amount,
            'target_amount' => $envelope->target_amount,
            'target_reached' => $envelope->target_reached,
            'notes' => $envelope->notes,
        ];
    }
}
