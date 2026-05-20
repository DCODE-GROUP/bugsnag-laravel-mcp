<?php

namespace Dcodegroup\BugsnagLaravelMcp\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bugsnag-mcp:install {--write= : The file path to write output to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Bugsnag MCP package';

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
            $existingServers = data_get($existingContent, 'mcpServers', []);
            data_set($existingServers, 'bugsnag', json_decode($snippet, true)['bugsnag']);
            data_set($existingContent, 'mcpServers', $existingServers);

            // Write output to file
            file_put_contents($write, json_encode($existingContent, JSON_PRETTY_PRINT));
            $this->info('Configuration written to '.$write);
        }
    }
}
