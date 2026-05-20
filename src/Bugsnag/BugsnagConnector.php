<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class BugsnagConnector extends Connector
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
}
