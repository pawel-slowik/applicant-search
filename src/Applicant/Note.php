<?php

declare(strict_types=1);

namespace Recruitment\Applicant;

class Note
{
    private string $note;

    public function __construct(string $note)
    {
        $this->note = $note;
    }

    public function __toString(): string
    {
        return $this->note;
    }
}
