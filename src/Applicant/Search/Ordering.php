<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search;

use Recruitment\Search\Ordering as AbstractOrdering;

class Ordering extends AbstractOrdering
{
    public const EMAIL = 1;

    public const FIRST_NAME = 2;

    public const LAST_NAME = 3;

    private int $field;

    public function __construct(int $field, bool $isAscending)
    {
        parent::__construct($isAscending);
        $this->field = $field;
    }

    public function getField(): int
    {
        return $this->field;
    }
}
