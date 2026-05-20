<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Organization\Requests;

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagOrganization;
use Override;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class OrganizationListRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/user/organizations';
    }

    #[Override]
    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();

        // if we only got back a single item, wrap it in an array so we can process it uniformly
        if (isset($data['id'])) {
            $data = [$data];
        }

        return BugsnagOrganization::collect($data);
    }
}
