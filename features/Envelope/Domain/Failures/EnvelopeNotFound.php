<?php
namespace Features\Envelope\Domain\Failures;

use Features\Core\Domain\Failure\ApiFailure;

class EnvelopeNotFound extends ApiFailure
{
    public function __construct()
    {
        parent::__construct(
            __('envelope_not_found'),
            404,
            'envelope_not_found'
        );
    }
}
