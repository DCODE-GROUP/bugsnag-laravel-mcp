<?php

use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagError;
use Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data\BugsnagEvent;
use Dcodegroup\BugsnagLaravelMcp\BugsnagClient;
use Dcodegroup\BugsnagLaravelMcp\Tools\GetBugsnagError;
use Laravel\Mcp\Request;

it('can execute the GetBugsnagError tool', function () {
    $projectId = fake()->uuid();
    $errorId = fake()->uuid();
    $eventId = fake()->uuid();
    config(['bugsnag-mcp.project_id' => $projectId]);

    $mockError = BugsnagError::from([
        'id' => $errorId,
        'project_id' => $projectId,
        'url' => "https://api.bugsnag.com/projects/{$projectId}/errors/{$errorId}",
        'project_url' => "https://api.bugsnag.com/projects/{$projectId}",
        'error_class' => 'InvalidArgumentException',
        'message' => 'Test error message',
        'severity' => 'error',
        'events' => 5,
        'events_url' => "https://api.bugsnag.com/projects/{$projectId}/errors/{$errorId}/events",
        'unthrottled_occurrence_count' => 5,
        'users' => 1,
        'first_seen' => '2026-05-18T11:16:27.688Z',
        'last_seen' => '2026-05-20T10:01:34.581Z',
        'first_seen_unfiltered' => '2026-05-18T11:16:27.688Z',
        'last_seen_unfiltered' => '2026-05-20T10:01:34.581Z',
        'status' => 'open',
        'comment_count' => 0,
        'discarded' => false,
    ]);

    $mockEvent = BugsnagEvent::from([
        'id' => $eventId,
        'url' => "https://api.bugsnag.com/projects/{$projectId}/events/{$eventId}",
        'project_url' => "https://api.bugsnag.com/projects/{$projectId}",
        'is_full_report' => true,
        'error_id' => $errorId,
        'received_at' => '2026-05-20T10:01:34.581Z',
        'context' => 'GET /test-page',
        'severity' => 'error',
        'unhandled' => true,
    ]);

    $mockClient = Mockery::mock(BugsnagClient::class);
    $mockClient->shouldReceive('getError')
        ->once()
        ->with($projectId, $errorId)
        ->andReturn($mockError);

    $mockClient->shouldReceive('getErrorEvents')
        ->once()
        ->with($projectId, $errorId)
        ->andReturn(collect([['id' => $eventId]]));

    $mockClient->shouldReceive('getEvent')
        ->once()
        ->with($projectId, $eventId)
        ->andReturn($mockEvent);

    app()->instance(BugsnagClient::class, $mockClient);

    $tool = new GetBugsnagError;
    $response = $tool->handle(new Request(['error_id' => $errorId]));

    $content = (string) $response->content();
    $data = json_decode($content, true);

    expect($data)->toHaveKey('error');
    expect($data)->toHaveKey('latest_event');
    expect($data)->toHaveKey('instructions_for_copilot');
    expect($data['error']['id'])->toBe($errorId);
    expect($data['error']['error_class'])->toBe('InvalidArgumentException');
    expect($data['latest_event']['id'])->toBe($eventId);
    expect($data['instructions_for_copilot'])->toBeArray();
    expect($data['instructions_for_copilot'])->toHaveCount(3);
});
