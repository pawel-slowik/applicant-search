<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search;

use Recruitment\Search\Ordering;
use Recruitment\Search\Pagination;

interface Index
{
    public const RETURN_BASIC = 1;

    public const RETURN_DETAILED = 2;

    public function queryWithCount(
        Criteria $criteria,
        Ordering $ordering,
        Pagination $pagination,
        int $returnType
    ): IndexResult;
}
