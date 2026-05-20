<?php

namespace Dcodegroup\BugsnagLaravelMcp;

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\BugsnagConnector;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagError;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagEvent;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Error\Requests\GetErrorRequest;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Event\Requests\GetErrorEventsRequest;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Event\Requests\GetEventRequest;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Organization\Requests\OrganizationListRequest;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Project\Requests\ProjectListRequest;
use Illuminate\Support\Collection;

class BugsnagClient
{
    protected string $apiBaseUrl;

    protected BugsnagConnector $connector;

    public function __construct()
    {
        $this->apiBaseUrl = config('bugsnag-mcp.api_base_url', 'https://api.bugsnag.com');
        $this->connector = new BugsnagConnector;
    }

    public function getOrganizations(): Collection
    {
        return collect($this->connector->send(new OrganizationListRequest)->dtoOrFail());
    }

    public function getProjects(string $organizationId): Collection
    {
        $request = (new ProjectListRequest)->setOrganizationId($organizationId);

        return collect($this->connector->send($request)->dtoOrFail());
    }

    public function getEvent(string $projectId, string $eventId): BugsnagEvent
    {
        $request = (new GetEventRequest)->setProjectId($projectId)->setEventId($eventId);

        return $this->connector->send($request)->dtoOrFail();
    }

    public function getErrorEvents(string $projectId, string $errorId): Collection
    {
        $request = (new GetErrorEventsRequest)->setProjectId($projectId)->setErrorId($errorId);

        return collect($this->connector->send($request)->dtoOrFail());
    }

    public function getError(string $projectId, string $errorId): BugsnagError
    {
        $request = (new GetErrorRequest)->setProjectId($projectId)->setErrorId($errorId);

        return $this->connector->send($request)->dtoOrFail();
    }
}
