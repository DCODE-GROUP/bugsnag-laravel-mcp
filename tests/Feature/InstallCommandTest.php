<?php

use Dcodegroup\BugsnagLaravelMcp\Console\Commands\Install;

it('outputs the mcp json snippet', function () {
    $this->artisan(Install::class, ['--no-interaction' => true])
        ->expectsOutputToContain('Add the following to your mcp.json')
        ->expectsOutputToContain('"bugsnag"')
        ->expectsOutputToContain('"mcp:start"')
        ->assertExitCode(0);
});

it('writes config to the specified file', function () {
    $file = tempnam(sys_get_temp_dir(), 'mcp').'.json';

    $this->artisan(Install::class, ['--write' => $file, '--no-interaction' => true])
        ->assertExitCode(0);

    expect(file_exists($file))->toBeTrue();

    $content = json_decode(file_get_contents($file), true);

    expect($content)->toHaveKey('mcpServers')
        ->and($content['mcpServers'])->toHaveKey('bugsnag')
        ->and($content['mcpServers']['bugsnag']['command'])->toBe('php')
        ->and($content['mcpServers']['bugsnag']['args'])->toContain('mcp:start');

    unlink($file);
});

it('merges with existing mcp json content when writing', function () {
    $file = tempnam(sys_get_temp_dir(), 'mcp').'.json';
    file_put_contents($file, json_encode(['mcpServers' => ['other-server' => ['command' => 'node']]], JSON_PRETTY_PRINT));

    $this->artisan(Install::class, ['--write' => $file, '--no-interaction' => true])
        ->assertExitCode(0);

    $content = json_decode(file_get_contents($file), true);

    expect($content)->toHaveKey('mcpServers')
        ->and($content['mcpServers'])->toHaveKey('bugsnag')
        ->and($content['mcpServers'])->toHaveKey('other-server');

    unlink($file);
});

it('skips writing when user declines the prompt', function () {
    $file = base_path('.mcp.json');
    if (file_exists($file)) {
        unlink($file);
    }

    $this->artisan(Install::class)
        ->expectsQuestion('Do you want to write this to your .mcp.json file?', false)
        ->assertExitCode(0);

    expect(file_exists($file))->toBeFalse();
});
