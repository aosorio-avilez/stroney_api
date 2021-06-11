<?php

namespace App\Features\Core\Framework\Transformer;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class FractalTransformer implements Transformer
{
    private Manager $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;
        $this->fractal->setSerializer(new FractalSerializer());
    }

    public function makeItem($data = null, TransformerAbstract $transformer, $resourceKey = 'data')
    {
        return $this->fractal->createData(new Item($data, $transformer, $resourceKey));
    }

    public function makeCollection(?array $data = null, TransformerAbstract $transformer, $resourceKey = 'data')
    {
        return $this->fractal->createData(new Collection($data, $transformer, $resourceKey));
    }
}
