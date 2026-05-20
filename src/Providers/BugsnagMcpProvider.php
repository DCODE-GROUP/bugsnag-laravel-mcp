<?php

namespace Dcodegroup\BugsnagLaravelMcp\Providers;

use Dcodegroup\BugsnagLaravelMcp\BugsnagServer;
use Dcodegroup\BugsnagLaravelMcp\Console\Commands\Install;
use Illuminate\Support\ServiceProvider;
use Laravel\Mcp\Facades\Mcp;

class BugsnagMcpProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/bugsnag-mcp.php',
            'bugsnag-mcp'
        );

        if (! $this->shouldRun()) {
            return;
        }
    }

    public function boot(): void
    {
        if (! $this->shouldRun()) {
            return;
        }

        Mcp::local('bugsnag', BugsnagServer::class);
        $this->registerPublishing();
        $this->registerCommands();
        $this->registerRoutes();
    }

    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/bugsnag-mcp.php' => config_path('bugsnag-mcp.php'),
            ], 'bugsnag-mcp-config');
        }
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class,
            ]);
        }
    }

    protected function registerRoutes(): void {}

    protected function shouldRun(): bool
    {
        if (app()->runningUnitTests()) {
            return false;
        }

        // Only enable Bugsnag MCP on local environments or when debug is true
        if (! app()->environment('local') && config('app.debug', false) !== true) {
            return false;
        }

        return true;
    }
}
