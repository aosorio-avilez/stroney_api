<?php

namespace App\Features\Core\Framework\Transformer;

use League\Fractal\TransformerAbstract;

interface Transformer
{
    public function makeItem($data = null, TransformerAbstract $transformer);

    public function makeCollection(array $data = null, TransformerAbstract $transformer);
}
