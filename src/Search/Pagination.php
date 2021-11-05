<?php

declare(strict_types=1);

namespace Recruitment\Search;

class Pagination
{
    private int $pageNumber;

    private int $pageSize;

    public function __construct(int $pageNumber, int $pageSize)
    {
        $this->pageNumber = $pageNumber;
        $this->pageSize = $pageSize;
    }

    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }
}
