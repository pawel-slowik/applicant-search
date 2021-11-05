<?php

declare(strict_types=1);

namespace Recruitment\Search;

use DateTimeImmutable;

class OptionalDateRange
{
    private bool $isNull;

    private DateTimeImmutable $begin;

    private DateTimeImmutable $end;

    public function __construct(DateTimeImmutable $begin, DateTimeImmutable $end)
    {
        $this->isNull = false;
        $this->begin = $begin;
        $this->end = $end;
    }

    public static function createNull(): self
    {
        $begin = (new DateTimeImmutable())->setDate(1, 1, 1);
        $end = (new DateTimeImmutable())->setDate(9999, 12, 31);
        $instance = new static($begin, $end);
        $instance->isNull = true;

        return $instance;
    }

    public function isNull(): bool
    {
        return $this->isNull;
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
