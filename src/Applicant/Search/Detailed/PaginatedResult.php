<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search\Detailed;

use Recruitment\Search\PaginatedResult as AbstractPaginatedResult;

class PaginatedResult extends AbstractPaginatedResult
{
    private array $currentPageEntries;

    public function __construct(int $currentPageNumber, int $pageCount, ApplicantDTO ...$currentPageEntries)
    {
        parent::__construct($currentPageNumber, $pageCount);
        $this->currentPageEntries = $currentPageEntries;
    }

    /**
     * @return ApplicantDTO[]
     */
    public function getCurrentPageEntries(): array
    {
        return $this->currentPageEntries;
    }
}
