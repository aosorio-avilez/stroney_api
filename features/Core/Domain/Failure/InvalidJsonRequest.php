<?php

namespace Features\Core\Domain\Failure;

class InvalidJsonRequest extends ApiFailure
{
    public function __construct()
    {
        parent::__construct(
            __('Invalid JSON request'),
            400,
            'invalid_json_request'
        );
    }
}
