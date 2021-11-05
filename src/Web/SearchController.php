<?php

declare(strict_types=1);

namespace Recruitment\Web;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Recruitment\Applicant\Search\SearchService;

class SearchController
{
    private SearchService $searchService;

    private SearchInputFactory $inputFactory;

    private DTOPresenter $presenter;

    public function __construct(
        SearchService $searchService,
        SearchInputFactory $inputFactory,
        DTOPresenter $presenter
    ) {
        $this->searchService = $searchService;
        $this->inputFactory = $inputFactory;
        $this->presenter = $presenter;
    }

    // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $routeArgs
    ): ResponseInterface {
        if (array_key_exists('details', $request->getQueryParams())) {
            $paginatedResult = $this->searchService->findDetailed(
                $this->inputFactory->criteriaFromRequest($request),
                $this->inputFactory->orderingFromRequest($request),
                $this->inputFactory->paginationFromRequest($request)
            );
        } else {
            $paginatedResult = $this->searchService->findBasic(
                $this->inputFactory->criteriaFromRequest($request),
                $this->inputFactory->orderingFromRequest($request),
                $this->inputFactory->paginationFromRequest($request)
            );
        }

        $data = [
            'data' => $this->presenter->present($paginatedResult->getCurrentPageEntries()),
            'pagination' => [
                'currentPage' => $paginatedResult->getCurrentPageNumber(),
                'pageCount' => $paginatedResult->getTotalPageCount(),
            ],
        ];

        $response->getBody()->write(json_encode($data, \JSON_THROW_ON_ERROR));
        $response = $response->withHeader('Content-Type', 'application/json');

        return $response;
    }
}
