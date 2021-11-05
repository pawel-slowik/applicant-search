<?php

declare(strict_types=1);

namespace Recruitment\Search;

abstract class Ordering
{
    private bool $isAscending;

    public function __construct(bool $isAscending)
    {
        $this->isAscending = $isAscending;
    }

    public function isAscending(): bool
    {
        return $this->isAscending;
    }

    abstract public function getField(): int;
}
