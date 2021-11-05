<?php

declare(strict_types=1);

namespace Recruitment\Applicant;

class Tag
{
    private string $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    public function __toString(): string
    {
        return $this->tag;
    }
}
