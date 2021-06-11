<?php

namespace App\Features\Core\Domain\Repository;

use Illuminate\Database\Eloquent\Model;

interface Repository
{
    public function getModel(): Model;
}
