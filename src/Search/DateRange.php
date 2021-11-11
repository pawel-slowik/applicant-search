<?php

declare(strict_types=1);

namespace Recruitment\Search;

use DateTimeImmutable;

class DateRange
{
    private DateTimeImmutable $begin;

    private DateTimeImmutable $end;

    public function __construct(DateTimeImmutable $begin, DateTimeImmutable $end)
    {
        $this->begin = $begin;
        $this->end = $end;
    }

    public function getBegin(): DateTimeImmutable
    {
        return $this->begin;
    }

    public function getEnd(): DateTimeImmutable
    {
        return $this->end;
    }
}
