<?php

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagProject;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Project\Requests\ProjectListRequest;
use Dcodegroup\BugsnagLaravelMcp\BugsnagClient;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\ProjectListFixture;

it('can list projects with a valid token', function () {
    MockClient::global([
        ProjectListRequest::class => new ProjectListFixture,
    ]);

    $service = app()->make(BugsnagClient::class);
    $projects = $service->getProjects(fake()->uuid());
    expect($projects)->toHaveCount(30);
    expect($projects)->each->toBeInstanceOf(BugsnagProject::class);
});
