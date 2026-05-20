<?php

namespace Dcodegroup\BugsnagLaravelMcp\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('bugsnag-mcp:install {--write= : The file path to write output to}')]
#[Description('Install the Bugsnag MCP package')]
class Install extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $write = $this->option('write');

        $snippet = json_encode([
            'bugsnag' => [
                'command' => 'php',
                'args' => [
                    'artisan',
                    'mcp:start',
                    'bugsnag',
                ],
                'cwd' => base_path(),
            ],
        ], JSON_PRETTY_PRINT);

        $this->info('Add the following to your mcp.json:');
        $lines = explode("\n", $snippet);
        foreach ($lines as $line) {
            $this->line($line);
        }

        if (! $write && ! $this->option('no-interaction')) {
            $write = file_exists(base_path('mcp.json')) ? base_path('mcp.json') : base_path('.mcp.json');
            if (! $this->confirm('Do you want to write this to your '.basename($write).' file?')) {
                return;
            }
        }

        if ($write) {
            // Read existing content if file exists
            $existingContent = file_exists($write) ? json_decode(file_get_contents($write), true) : [];
            // Merge with existing content
            $mergedContent = array_merge($existingContent, json_decode($snippet, true));
            // Write output to file
            file_put_contents($write, json_encode($mergedContent, JSON_PRETTY_PRINT));
            $this->info('Configuration written to '.$write);
        }
    }
}
