<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search;

class IndexResult
{
    private array $entries;

    private int $totalCount;

    public function __construct(array $entries, int $totalCount)
    {
        $this->entries = $entries;
        $this->totalCount = $totalCount;
    }

    public function getEntries(): array
    {
        return $this->entries;
    }

    public function getTotalCount(): int
    {
        return $this->totalCount;
    }
}
