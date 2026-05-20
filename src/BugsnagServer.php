<?php

namespace Dcodegroup\BugsnagLaravelMcp;

use Dcodegroup\BugsnagLaravelMcp\Tools\GetBugsnagError;
use Dcodegroup\BugsnagLaravelMcp\Tools\GetOpenBugsnagErrors;
use Laravel\Mcp\Server;
use Laravel\Mcp\Server\Attributes\Instructions;
use Laravel\Mcp\Server\Attributes\Name;
use Laravel\Mcp\Server\Attributes\Version;

#[Name('Bugsnag Server')]
#[Version('0.0.1')]
#[Instructions('This server provides access to Bugsnag error data for the Laravel application. It can fetch error details by error ID, which can then be used to infer root causes, suggest reproduction steps, and point to relevant files in the codebase for inspection.')]
class BugsnagServer extends Server
{
    protected array $tools = [
        GetBugsnagError::class,
        GetOpenBugsnagErrors::class,
    ];

    protected array $resources = [
        //
    ];

    protected array $prompts = [
        //
    ];
}
