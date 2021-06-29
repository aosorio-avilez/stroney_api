<?php
namespace App\Http\Controllers;

use App\Models\Envelope;
use Features\Envelope\Domain\Usecases\CreateEnvelopeUseCase;
use Features\Envelope\Presentation\Transformers\EnvelopeTransformer;
use Features\Envelope\Presentation\Validators\CreateEnvelopeValidator;
use Features\User\Domain\Usecases\GetUserUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnvelopeController extends Controller
{
    public function create(
        Request $request,
        CreateEnvelopeValidator $createEnvelopeValidator,
        GetUserUseCase $getUserUseCase,
        CreateEnvelopeUseCase $createEnvelopeUseCase,
        EnvelopeTransformer $envelopeTransformer
    ): JsonResponse {
        $attributes = $createEnvelopeValidator->validate($request->all());

        $getUserUseCase->handle($attributes['user_id']);

        $envelope = new Envelope($attributes);
        $envelope = $createEnvelopeUseCase->handle($attributes['user_id'], $envelope);

        $resource = $this->fractal->makeItem($envelope, $envelopeTransformer);

        return jsonResponse(201, $resource->toArray());
    }
}
