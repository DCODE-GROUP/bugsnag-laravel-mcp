<?php

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagError;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Error\Requests\GetErrorRequest;
use Dcodegroup\BugsnagLaravelMcp\BugsnagClient;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\GetErrorFixture;

it('can retrieve a single error', function () {
    MockClient::global([
        GetErrorRequest::class => new GetErrorFixture,
    ]);

    $service = app()->make(BugsnagClient::class);

    $error = $service->getError(fake()->uuid(), fake()->uuid());
    expect($error)->toBeInstanceOf(BugsnagError::class);
});
