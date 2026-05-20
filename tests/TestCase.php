<?php

namespace Tests;

use Dcodegroup\BugsnagLaravelMcp\Console\Commands\Install;
use Dcodegroup\BugsnagLaravelMcp\Providers\BugsnagMcpProvider;
use Illuminate\Contracts\Console\Kernel;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Saloon\Http\Faking\MockClient;
use Spatie\LaravelData\LaravelDataServiceProvider;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelDataServiceProvider::class,
            BugsnagMcpProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Reset Saloon's static global mock so each test can define its own fixtures.
        MockClient::destroyGlobal();

        // The provider skips command registration during tests, so we register manually.
        $this->app->make(Kernel::class)->registerCommand(
            $this->app->make(Install::class)
        );
    }
}
