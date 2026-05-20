<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Error\Requests;

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagError;
use Override;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetErrorRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    protected string $projectId;

    protected string $errorId;

    public function setProjectId(string $projectId): static
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function setErrorId(string $errorId): static
    {
        $this->errorId = $errorId;

        return $this;
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/projects/'.$this->projectId.'/errors/'.$this->errorId;
    }

    #[Override]
    public function createDtoFromResponse(Response $response): mixed
    {
        $data = $response->json();

        return BugsnagError::from($data);
    }
}
