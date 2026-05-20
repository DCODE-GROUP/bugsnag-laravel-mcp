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

    $error = $service->getError('69d5c9eb1adebd001e647a4d', '6a0af4dc8c3285d1a53ea587');
    expect($error)->toBeInstanceOf(BugsnagError::class);
});
