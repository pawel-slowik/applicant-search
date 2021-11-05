<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search;

use Recruitment\Search\OptionalDateRange;
use Recruitment\Search\Phrase;

class Criteria
{
    private Phrase $phrase;

    private OptionalDateRange $dateOfBirth;

    public function __construct(Phrase $phrase, OptionalDateRange $dateOfBirth)
    {
        $this->phrase = $phrase;
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getPhrase(): Phrase
    {
        return $this->phrase;
    }

    public function getDateOfBirth(): OptionalDateRange
    {
        return $this->dateOfBirth;
    }
}
