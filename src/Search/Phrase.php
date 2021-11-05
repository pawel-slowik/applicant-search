<?php

declare(strict_types=1);

namespace Recruitment\Search;

class Phrase
{
    /**
     * @var string[]
     */
    private array $words;

    public function __construct(string $phrase)
    {
        // could do boolean expression / tag analysis here (or in a factory)
        $this->words = preg_split('/\s/', $phrase, \PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @return string[]
     */
    public function getWords(): array
    {
        return $this->words;
    }
}
