<?php

namespace App\Features\Core\Data;

use App\Features\Core\Domain\Entity\Entity;

interface Convertable
{
    public function convert(): Entity;
}
