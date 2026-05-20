<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Project\Requests;

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagProject;
use Override;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\PaginationPlugin\Contracts\Paginatable;

class ProjectListRequest extends Request implements Paginatable
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    protected string $organizationId;

    public function setOrganizationId(string $organizationId): static
    {
        $this->organizationId = $organizationId;

        return $this;
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/organizations/'.$this->organizationId.'/projects';
    }

    #[Override]
    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();

        // if we only got back a single item, wrap it in an array so we can process it uniformly
        if (isset($data['id'])) {
            $data = [$data];
        }

        return BugsnagProject::collect($data);
    }
}
