<?php

declare(strict_types=1);

namespace Recruitment\Test\Applicant\Search;

use PHPUnit\Framework\TestCase;
use Recruitment\Applicant\Search\Basic\ApplicantDTO as BasicApplicantDTO;
use Recruitment\Applicant\Search\Basic\ApplicantDTOFactory as BasicApplicantDTOFactory;
use Recruitment\Applicant\Search\Criteria;
use Recruitment\Applicant\Search\Detailed\ApplicantDTO as DetailedApplicantDTO;
use Recruitment\Applicant\Search\Detailed\ApplicantDTOFactory as DetailedApplicantDTOFactory;
use Recruitment\Applicant\Search\Index;
use Recruitment\Applicant\Search\IndexResult;
use Recruitment\Applicant\Search\Ordering;
use Recruitment\Applicant\Search\SearchService;
use Recruitment\Search\Pagination;
use Recruitment\Search\Phrase;

/**
 * @covers \Recruitment\Applicant\Search\SearchService
 */
class SearchServiceTest extends TestCase
{
    private SearchService $searchService;

    private $index;

    private $basicApplicantDTOFactory;

    private $detailedApplicantDTOFactory;

    protected function setUp(): void
    {
        $this->index = $this->createStub(Index::class);
        $this->basicApplicantDTOFactory = $this->createStub(BasicApplicantDTOFactory::class);
        $this->detailedApplicantDTOFactory = $this->createStub(DetailedApplicantDTOFactory::class);
        $this->searchService = new SearchService(
            $this->index,
            $this->basicApplicantDTOFactory,
            $this->detailedApplicantDTOFactory
        );
    }

    public function testBasicSearch(): void
    {
        $indexResult = $this->createStub(IndexResult::class);
        $indexResult
            ->method('getEntries')
            ->willReturn(array_fill(0, 20, []));
        $indexResult
            ->method('getTotalCount')
            ->willReturn(150);

        $this->index
            ->method('queryWithCount')
            ->willReturn($indexResult);

        $result = $this->searchService->findBasic(
            new Criteria(
                new Phrase('foo'),
                null
            ),
            new Ordering(Ordering::EMAIL, true),
            new Pagination(1, 100)
        );

        $this->assertContainsOnlyInstancesOf(BasicApplicantDTO::class, $result->getCurrentPageEntries());
        $this->assertCount(20, $result->getCurrentPageEntries());
        $this->assertSame(1, $result->getCurrentPageNumber());
        $this->assertSame(2, $result->getTotalPageCount());
    }

    public function testDetailedSearch(): void
    {
        $indexResult = $this->createStub(IndexResult::class);
        $indexResult
            ->method('getEntries')
            ->willReturn(array_fill(0, 10, []));
        $indexResult
            ->method('getTotalCount')
            ->willReturn(150);

        $this->index
            ->method('queryWithCount')
            ->willReturn($indexResult);

        $result = $this->searchService->findDetailed(
            new Criteria(
                new Phrase('foo'),
                null
            ),
            new Ordering(Ordering::EMAIL, true),
            new Pagination(2, 20)
        );

        $this->assertContainsOnlyInstancesOf(DetailedApplicantDTO::class, $result->getCurrentPageEntries());
        $this->assertCount(10, $result->getCurrentPageEntries());
        $this->assertSame(2, $result->getCurrentPageNumber());
        $this->assertSame(8, $result->getTotalPageCount());
    }
}
