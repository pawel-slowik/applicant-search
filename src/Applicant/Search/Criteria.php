<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search;

use Recruitment\Search\DateRange;
use Recruitment\Search\Phrase;

class Criteria
{
    private Phrase $phrase;

    private ?DateRange $dateOfBirth;

    public function __construct(Phrase $phrase, ?DateRange $dateOfBirth)
    {
        $this->phrase = $phrase;
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getPhrase(): Phrase
    {
        return $this->phrase;
    }

    public function getDateOfBirth(): ?DateRange
    {
        return $this->dateOfBirth;
    }
}
