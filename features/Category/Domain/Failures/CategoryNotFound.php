<?php

namespace Features\Category\Domain\Failures;

use Features\Core\Domain\Failure\ApiFailure;

class CategoryNotFound extends ApiFailure
{
    public function __construct()
    {
        parent::__construct(
            __('category_not_found'),
            404,
            'category_not_found'
        );
    }
}
