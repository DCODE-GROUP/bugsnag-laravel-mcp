<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag;

use Override;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\PaginationPlugin\Contracts\HasPagination;
use Saloon\PaginationPlugin\Paginator;
use Saloon\Traits\Plugins\AcceptsJson;

class BugsnagConnector extends Connector implements HasPagination
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return config('bugsnag-mcp.api_base_url', 'https://api.bugsnag.com');
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        $token = config('bugsnag-mcp.access_token');

        return [
            'Authorization' => "token {$token}",
        ];
    }

    #[Override]
    public function paginate(Request $request): Paginator
    {
        return new BugsnagPaginator($this, $request);
    }
}
