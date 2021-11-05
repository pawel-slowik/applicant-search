<?php

declare(strict_types=1);

namespace Recruitment\Search;

use UnexpectedValueException;

class Phrase
{
    private const MAX_LENGTH = 200;
    /**
     * @var string[]
     */
    private array $words;

    public function __construct(string $phrase)
    {
        if (!self::validate($phrase)) {
            throw new UnexpectedValueException();
        }
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

    private static function validate($phrase): bool
    {
        if (mb_strlen($phrase, 'UTF-8') > self::MAX_LENGTH) {
            return false;
        }

        return true;
    }
}
