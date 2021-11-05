<?php

declare(strict_types=1);

namespace Recruitment\Applicant;

class EmailAddress
{
    private string $address;

    public function __construct(string $address)
    {
        $this->address = $address;
    }

    public function __toString(): string
    {
        return $this->address;
    }
}
