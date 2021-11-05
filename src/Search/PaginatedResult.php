<?php

declare(strict_types=1);

namespace Recruitment\Search;

abstract class PaginatedResult
{
    private int $currentPageNumber;

    private int $pageCount;

    public function __construct(int $currentPageNumber, int $pageCount)
    {
        $this->currentPageNumber = $currentPageNumber;
        $this->pageCount = $pageCount;
    }

    public function getCurrentPageNumber(): int
    {
        return $this->currentPageNumber;
    }

    public function getTotalPageCount(): int
    {
        return $this->pageCount;
    }

    abstract public function getCurrentPageEntries();
}
