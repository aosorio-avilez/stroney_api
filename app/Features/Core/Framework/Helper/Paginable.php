<?php

namespace App\Features\Core\Framework\Helper;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;

trait Paginable
{
    /**
     * Indicates if a model is paginable or not
     *
     * @var boolean
     */
    public bool $withPagination = true;

    /**
     * Indicates the number of items per page
     *
     * @var integer
     */
    public int $itemsPerPage = 10;

    /**
     * Get pagination
     *
     * @param Builder $query
     * @return null|Paginator
     */
    public function getPagination(Builder $query): ?Paginator
    {
        // Check if pagination is enabled
        if ($this->withPagination) {
            // Add pagination to query builder
            return $query->simplePaginate($this->itemsPerPage);
        }

        // Return null if the pagination is disabled
        return null;
    }
}
