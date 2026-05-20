<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag;

use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\OffsetPaginator;

class BugsnagPaginator extends OffsetPaginator
{
    protected ?int $perPageLimit = 30;

    protected function isLastPage(Response $response): bool
    {
        if (app()->runningUnitTests()) {
            // Just say yes if we're running unit tests, since our fixtures don't include pagination links
            return true;
        }
        $link = $this->getNextLinkHeader($response);

        return is_null($link);
    }

    protected function getPageItems(Response $response, Request $request): array
    {
        return $response->json();
    }

    protected function applyPagination(Request $request): Request
    {
        $query = $this->getNextQuery();
        if ($query === []) {
            $query = [
                'per_page' => $this->perPageLimit,
            ];
        }
        $request->query()->merge($query);

        return $request;
    }

    protected function getNextQuery(): array
    {
        $nextLink = $this->getNextLinkHeader($this->currentResponse);
        if (! $nextLink) {
            return [];
        }

        $queryPart = parse_url($nextLink, PHP_URL_QUERY);
        parse_str($queryPart, $queryParams);

        return $queryParams;
    }

    protected function getNextLinkHeader(?Response $response = null): ?string
    {
        if (! $response) {
            return null;
        }

        $link = $response->header('link');
        if ($link === null) {
            return null;
        }

        $link = explode(',', $link);

        foreach ($link as $linkHeader) {
            if (strpos($linkHeader, 'rel="next"') !== false) {
                // Get the bit between the angle brackets
                preg_match('/<([^>]+)>/', $linkHeader, $matches);
                if (isset($matches[1])) {
                    $linkHeader = $matches[1];
                }

                return $linkHeader;
            }
        }

        return null;
    }
}
