<?php

namespace Dcodegroup\BugsnagLaravelMcp;

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\BugsnagConnector;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagError;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagEvent;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagProject;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Error\Requests\ErrorListRequest;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Error\Requests\GetErrorRequest;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Event\Requests\GetErrorEventsRequest;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Event\Requests\GetEventRequest;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Organization\Requests\OrganizationListRequest;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Project\Requests\ProjectListRequest;
use Illuminate\Support\Collection;

class BugsnagClient
{
    protected BugsnagConnector $connector;

    public function __construct()
    {
        $this->connector = new BugsnagConnector;
    }

    public function getOrganizations(): Collection
    {
        return collect($this->connector->send(new OrganizationListRequest)->dtoOrFail());
    }

    public function getProjects(string $organizationId): Collection
    {
        $request = (new ProjectListRequest)->setOrganizationId($organizationId);

        $items = $this->connector->paginate($request)->items();

        $results = collect();
        foreach ($items as $item) {
            $results->push(BugsnagProject::from($item));
        }

        return $results;
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

    public function getErrors(string $projectId): Collection
    {
        $request = (new ErrorListRequest)->setProjectId($projectId);
        $errorsPaginator = $this->connector->paginate($request);

        $items = $errorsPaginator->items();
        $results = collect();
        foreach ($items as $item) {
            $results->push(BugsnagError::from($item));
        }

        return $results;
    }

    public function getOpenErrors(string $projectId): Collection
    {
        $request = (new ErrorListRequest)->setProjectId($projectId)->setFilters([
            'error.status' => 'open',
        ]);

        $errorsPaginator = $this->connector->paginate($request);

        $items = $errorsPaginator->items();
        $results = collect();
        foreach ($items as $item) {
            $results->push(BugsnagError::from($item));
        }

        return $results;
    }
}
