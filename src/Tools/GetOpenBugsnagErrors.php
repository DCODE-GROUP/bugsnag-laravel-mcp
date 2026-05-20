<?php

namespace Dcodegroup\BugsnagLaravelMcp\Tools;

use Dcodegroup\BugsnagLaravelMcp\BugsnagClient;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Attributes\Description;
use Laravel\Mcp\Server\Tool;

#[Description('Fetches a list of currently open Bugsnag errors, sorted by the most recently seen errors first')]
class GetOpenBugsnagErrors extends Tool
{
    public function handle(Request $request): Response
    {
        $projectId = config('bugsnag-mcp.project_id');

        $client = app(BugsnagClient::class);

        $errors = $client->getOpenErrors($projectId);

        return Response::text(json_encode([
            'errors' => $errors,
        ], JSON_PRETTY_PRINT));
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }
}
