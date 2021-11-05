<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search;

use Recruitment\Applicant\Search\Basic\ApplicantDTOFactory as BasicApplicantDTOFactory;
use Recruitment\Applicant\Search\Basic\PaginatedResult as BasicPaginatedResult;
use Recruitment\Applicant\Search\Detailed\ApplicantDTOFactory as DetailedApplicantDTOFactory;
use Recruitment\Applicant\Search\Detailed\PaginatedResult as DetailedPaginatedResult;
use Recruitment\Search\Pagination;

class SearchService
{
    private Index $index;

    // if the index doesn't contain all the information that's necessary for
    // building DTOs, load what's missing from a repository (query by ids)
    // private ApplicantRepository $applicantRepository;

    private BasicApplicantDTOFactory $basicApplicantDTOFactory;

    private DetailedApplicantDTOFactory $detailedApplicantDTOFactory;

    public function __construct(
        Index $index,
        BasicApplicantDTOFactory $basicApplicantDTOFactory,
        DetailedApplicantDTOFactory $detailedApplicantDTOFactory
    ) {
        $this->index = $index;
        $this->basicApplicantDTOFactory = $basicApplicantDTOFactory;
        $this->detailedApplicantDTOFactory = $detailedApplicantDTOFactory;
    }

    public function findBasic(Criteria $criteria, Ordering $ordering, Pagination $pagination): BasicPaginatedResult
    {
        $indexResult = $this->index->queryWithCount($criteria, $ordering, $pagination, Index::RETURN_BASIC);

        $result = [];
        foreach ($indexResult->getEntries() as $entry) {
            $result[] = $this->basicApplicantDTOFactory->fromArray($entry);
        }

        return new BasicPaginatedResult(
            $pagination->getPageNumber(),
            self::calculatePageCount($indexResult->getTotalCount(), $pagination->getPageSize()),
            ...$result
        );
    }

    public function findDetailed(Criteria $criteria, Ordering $ordering, Pagination $pagination): DetailedPaginatedResult
    {
        $indexResult = $this->index->queryWithCount($criteria, $ordering, $pagination, Index::RETURN_DETAILED);

        $result = [];
        foreach ($indexResult->getEntries() as $entry) {
            $result[] = $this->detailedApplicantDTOFactory->fromArray($entry);
        }

        return new DetailedPaginatedResult(
            $pagination->getPageNumber(),
            self::calculatePageCount($indexResult->getTotalCount(), $pagination->getPageSize()),
            ...$result
        );
    }

    private static function calculatePageCount(int $totalEntryCount, int $pageSize): int
    {
        return (int) ceil($totalEntryCount / $pageSize);
    }
}
