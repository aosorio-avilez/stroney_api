<?php

namespace Features\Core\Framework\Transformer;

use Illuminate\Contracts\Pagination\Paginator;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
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

    public function makeCollection(
        ?array $data = null,
        TransformerAbstract $transformer,
        $resourceKey = 'data'
    ) {
        return $this->fractal->createData(new Collection($data, $transformer, $resourceKey));
    }

    public function makePagination(
        ?array $data = null,
        TransformerAbstract $transformer,
        Paginator $paginator
    ) {
        $collection = new Collection($data, $transformer, 'data');
        $collection->setPaginator(new IlluminatePaginatorAdapter($paginator));
        return $this->fractal->createData($collection);
    }
}
