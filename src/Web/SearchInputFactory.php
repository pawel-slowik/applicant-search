<?php

declare(strict_types=1);

namespace Recruitment\Web;

use DateTimeImmutable;
use Psr\Http\Message\ServerRequestInterface;
use Recruitment\Applicant\Search\Criteria;
use Recruitment\Applicant\Search\Ordering;
use Recruitment\Search\OptionalDateRange;
use Recruitment\Search\Pagination;
use Recruitment\Search\Phrase;
use UnexpectedValueException;

class SearchInputFactory
{
    private const DATE_FORMAT = 'Y-m-d';

    public function criteriaFromRequest(ServerRequestInterface $request): Criteria
    {
        $queryParams = $request->getQueryParams();

        return new Criteria(
            $this->phraseFromQueryParams($queryParams),
            $this->dateOfBirthFromQueryParams($queryParams)
        );
    }

    private function phraseFromQueryParams(array $queryParams): Phrase
    {
        if (array_key_exists('phrase', $queryParams)) {
            return new Phrase($queryParams['phrase']);
        }

        return new Phrase('');
    }

    private function dateOfBirthFromQueryParams(array $queryParams): OptionalDateRange
    {
        if (
            array_key_exists('dateOfBirth', $queryParams)
            && is_array($queryParams['dateOfBirth'])
            && array_key_exists('from', $queryParams['dateOfBirth'])
            && array_key_exists('to', $queryParams['dateOfBirth'])
        ) {
            return new OptionalDateRange(
                $this->dateFromString($queryParams['dateOfBirth']['from']),
                $this->dateFromString($queryParams['dateOfBirth']['to'])
            );
        }

        return OptionalDateRange::createNull();
    }

    private function dateFromString(string $date): DateTimeImmutable
    {
        $date = DateTimeImmutable::createFromFormat(self::DATE_FORMAT, $date);
        if (false === $date) {
            throw new UnexpectedValueException();
        }

        return $date;
    }

    public function orderingFromRequest(ServerRequestInterface $request): Ordering
    {
        $queryParams = $request->getQueryParams();

        return new Ordering(
            $this->orderingFieldFromQueryParams($queryParams),
            $this->orderingAscendingFromQueryParams($queryParams)
        );
    }

    private function orderingFieldFromQueryParams(array $queryParams): int
    {
        $sortMap = [
            'email' => Ordering::EMAIL,
            'first' => Ordering::FIRST_NAME,
            'last' => Ordering::LAST_NAME,
        ];
        if (array_key_exists('sort', $queryParams)) {
            if (array_key_exists($queryParams['sort'], $sortMap)) {
                return $sortMap[$queryParams['sort']];
            }
        }

        return Ordering::EMAIL;
    }

    private function orderingAscendingFromQueryParams(array $queryParams): bool
    {
        if (array_key_exists('desc', $queryParams)) {
            return false;
        }

        return true;
    }

    public function paginationFromRequest(ServerRequestInterface $request): Pagination
    {
        $queryParams = $request->getQueryParams();

        return new Pagination($this->pageNumberFromQueryParams($queryParams), 20);
    }

    private function pageNumberFromQueryParams(array $queryParams): int
    {
        if (array_key_exists('page', $queryParams)) {
            $page = (int) $queryParams['page'];
            if ($page > 0) {
                return $page;
            }
        }

        return 1;
    }
}
