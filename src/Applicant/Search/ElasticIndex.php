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

        if (Index::RETURN_DETAILED === $returnType) {
            $entry = [
                'email' => 'alice.smith@example.com',
                'first_name' => 'Alice',
                'last_name' => 'Smith',
                'tags' => [
                    'foo',
                ],
                'notes' => [
                    'bar',
                    'baz',
                ],
            ];
        } else {
            $entry = [
                'email' => 'alice.smith@example.com',
                'first_name' => 'Alice',
                'last_name' => 'Smith',
            ];
        }

        $entries = array_fill(0, $pagination->getPageSize(), $entry);
        $totalCount = 25;

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
