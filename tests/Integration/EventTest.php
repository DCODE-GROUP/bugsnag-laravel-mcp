<?php

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagEvent;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Event\Requests\GetErrorEventsRequest;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Event\Requests\GetEventRequest;
use Dcodegroup\BugsnagLaravelMcp\BugsnagClient;
use Saloon\Http\Faking\MockClient;
use Tests\Fixtures\GetErrorEventsFixture;
use Tests\Fixtures\GetEventFixture;

it('can retrieve a single event', function () {
    MockClient::global([
        GetEventRequest::class => new GetEventFixture,
    ]);

    $service = app()->make(BugsnagClient::class);

    $event = $service->getEvent(fake()->uuid(), fake()->uuid());
    expect($event)->toBeInstanceOf(BugsnagEvent::class);
});

it('can retrieve a list of events for an error', function () {
    MockClient::global([
        GetErrorEventsRequest::class => new GetErrorEventsFixture,
    ]);

    $service = app()->make(BugsnagClient::class);

    $events = $service->getErrorEvents(fake()->uuid(), fake()->uuid());
    expect($events)->toHaveCount(9);

    // Ensure that it's a collection of BugsnagEvent objects
    expect($events)->each->toBeInstanceOf(BugsnagEvent::class);
});
