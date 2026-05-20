<?php

namespace Dcodegroup\BugsnagLaravelMcp\Tools;

use Dcodegroup\BugsnagLaravelMcp\BugsnagClient;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Fetches a Bugsnag error by ID, including the most recent event, stack traces, request context, breadcrumbs, and metadata for root-cause analysis. Use this when the user asks about a Bugsnag error ID.')]
class GetBugsnagError extends Tool
{
    public function handle(Request $request): Response
    {
        $errorId = $request->get('error_id');
        $projectId = config('bugsnag-mcp.project_id');

        $client = app(BugsnagClient::class);

        $error = $client->getError($projectId, $errorId);

        $events = $client->getErrorEvents($projectId, $errorId);

        $latestEvent = $client->getEvent($projectId, $events[0]['id']);

        return Response::text(json_encode([
            'error' => $error,
            'latest_event' => $latestEvent,
            'instructions_for_copilot' => config('bugsnag-mcp.copilot_instructions'),
        ], JSON_PRETTY_PRINT));
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'error_id' => $schema
                ->string()
                ->description('The Bugsnag error ID to fetch.'),
        ];
    }
}
