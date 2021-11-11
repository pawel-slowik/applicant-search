<?php

declare(strict_types=1);

namespace Recruitment\Test\Applicant\Search;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Recruitment\Applicant\Search\Ordering;
use Recruitment\Web\SearchInputFactory;
use UnexpectedValueException;

/**
 * @covers \Recruitment\Web\SearchInputFactory
 */
class SearchInputFactoryTest extends TestCase
{
    private SearchInputFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new SearchInputFactory();
    }

    public function testPhrase(): void
    {
        $queryParams = [
            'phrase' => 'foo bar',
        ];

        $criteria = $this->factory->criteriaFromRequest(
            $this->createRequestStubWithParams($queryParams)
        );

        $this->assertNotEmpty($criteria->getPhrase()->getWords());
    }

    public function testValidDates(): void
    {
        $queryParams = [
            'dateOfBirth' => [
                'from' => '1990-11-21',
                'to' => '2020-01-02',
            ],
        ];

        $criteria = $this->factory->criteriaFromRequest(
            $this->createRequestStubWithParams($queryParams)
        );

        $this->assertEquals('1990', $criteria->getDateOfBirth()->getBegin()->format('Y'));
        $this->assertEquals('11', $criteria->getDateOfBirth()->getBegin()->format('n'));
        $this->assertEquals('21', $criteria->getDateOfBirth()->getBegin()->format('j'));
        $this->assertEquals('2020', $criteria->getDateOfBirth()->getEnd()->format('Y'));
        $this->assertEquals('1', $criteria->getDateOfBirth()->getEnd()->format('n'));
        $this->assertEquals('2', $criteria->getDateOfBirth()->getEnd()->format('j'));
    }

    public function testEmptyDates(): void
    {
        $criteria = $this->factory->criteriaFromRequest(
            $this->createRequestStubWithParams([])
        );

        $this->assertNull($criteria->getDateOfBirth());
    }

    public function testInvalidDates(): void
    {
        $queryParams = [
            'dateOfBirth' => [
                'from' => 'foo',
                'to' => 'bar',
            ],
        ];

        $this->expectException(UnexpectedValueException::class);

        $this->factory->criteriaFromRequest(
            $this->createRequestStubWithParams($queryParams)
        );
    }

    /**
     * @dataProvider orderingDataProvider
     */
    public function testOrdering(array $queryParams, int $expectedField, bool $expectedAscending): void
    {
        $ordering = $this->factory->orderingFromRequest(
            $this->createRequestStubWithParams($queryParams)
        );

        $this->assertSame($expectedField, $ordering->getField());
        $this->assertSame($expectedAscending, $ordering->isAscending());
    }

    public function orderingDataProvider(): array
    {
        return [
            [
                [],
                Ordering::EMAIL,
                true,
            ],
            [
                [
                    'sort' => 'first',
                    'desc' => '',
                ],
                Ordering::FIRST_NAME,
                false,
            ],
        ];
    }

    /**
     * @dataProvider paginationDataProvider
     */
    public function testPagination(array $queryParams, int $expectedPage): void
    {
        $pagination = $this->factory->paginationFromRequest(
            $this->createRequestStubWithParams($queryParams)
        );

        $this->assertSame($expectedPage, $pagination->getPageNumber());
        $this->assertSame(20, $pagination->getPageSize());
    }

    public function paginationDataProvider(): array
    {
        return [
            [[], 1],
            [['page' => '100'], 100],
            [['page' => 'foo'], 1],
            [['page' => '-1'], 1],
            [['page' => 0], 1],
        ];
    }

    private function createRequestStubWithParams(array $queryParams): ServerRequestInterface
    {
        $request = $this->createStub(ServerRequestInterface::class);
        $request
            ->method('getQueryParams')
            ->willReturn($queryParams);

        return $request;
    }
}
