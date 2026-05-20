<?php

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagOrganization;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Organization\Requests\OrganizationListRequest;
use Dcodegroup\BugsnagLaravelMcp\BugsnagClient;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\OrganizationListFixture;

it('can list organizations with a valid token', function () {
    MockClient::global([
        OrganizationListRequest::class => new OrganizationListFixture,
    ]);

    $service = app()->make(BugsnagClient::class);
    $organizations = $service->getOrganizations();
    expect($organizations)->toHaveCount(1);
    expect($organizations)->each->toBeInstanceOf(BugsnagOrganization::class);
});
