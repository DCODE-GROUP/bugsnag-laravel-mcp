<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Error\Requests;

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagError;
use Override;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class ErrorListRequest extends Request implements Paginatable
{
    protected string $projectId;

    protected array $filters = [];

    protected Method $method = Method::GET;

    public function setProjectId(string $projectId): static
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/projects/'.$this->projectId.'/errors?per_page=10';
    }

    #[Override]
    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();

        return BugsnagError::collect($data);
    }

    protected function defaultQuery(): array
    {
        $query = [
            'per_page' => 100,
        ];

        if (! empty($this->filters)) {
            $query = array_merge($query, ['filters' => $this->filters]);
        }

        return $query;
    }

    public function setFilters(array $filters): static
    {
        $this->filters = $filters;

        return $this;
    }
}
