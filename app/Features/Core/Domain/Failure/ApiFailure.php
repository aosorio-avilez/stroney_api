<?php

declare(strict_types=1);

namespace App\Features\Core\Domain\Failure;

abstract class ApiFailure extends \RuntimeException
{
    private ?string $error;

    public function __construct(string $message, int $code, ?string $error = null)
    {
        parent::__construct($message, $code);
        $this->error = $error;
    }

    function getError(): ?string {
        return $this->error;
    }
}
