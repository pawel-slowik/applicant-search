<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search;

use Recruitment\Search\Ordering;
use Recruitment\Search\Pagination;

class ElasticIndex implements Index
{
    public function __construct()
    {
        // @TODO: inject Elasticsearch client here
    }

    public function queryWithCount(
        Criteria $criteria,
        Ordering $ordering,
        Pagination $pagination,
        int $returnType
    ): IndexResult {
        $searchParams = $this->createParams($criteria, $ordering, $pagination, $returnType);

        // @TODO: execute the search using $searchParams
        $entries = [];
        $totalCount = 0;

        return new IndexResult($entries, $totalCount);
    }

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    private function createParams(
        Criteria $criteria,
        Ordering $ordering,
        Pagination $pagination,
        int $returnType
    ): array {
        // @TODO: create the search parameters
        // extract into a query builder if the method gets too big

        return [];
    }
}
