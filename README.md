# Bugsnag Laravel MCP

A Laravel package that integrates [Bugsnag](https://www.bugsnag.com/) error monitoring with [Model Context Protocol (MCP)](https://modelcontextprotocol.io/), enabling AI assistants like Claude to access and analyze Bugsnag error data directly.

## Features

- 🔗 **MCP Server Integration**: Exposes Bugsnag error data through the Model Context Protocol
- 🐛 **Error Analysis**: Fetch detailed error information including stack traces, events, and context
- 🤖 **AI-Ready**: Built for seamless integration with AI assistants and large language models
- 📋 **Full Event History**: Access the latest event details for any Bugsnag error
- 🔐 **Secure**: Uses personal access tokens for authentication with the Bugsnag API

## Requirements

- PHP 8.1+
- Laravel 11+
- Bugsnag account with personal access token

## Installation

Install the package via Composer:

```bash
composer require dcodegroup/bugsnag-laravel-mcp
```

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Dcodegroup\BugsnagLaravelMcp\Providers\BugsnagMcpProvider" --tag=bugsnag-mcp-config
```

## Configuration

Add the following environment variables to your `.env` file:

```env
BUGSNAG_PERSONAL_ACCESS_TOKEN=your_bugsnag_personal_access_token
BUGSNAG_ORGANIZATION_ID=your_organization_id
BUGSNAG_PROJECT_ID=your_project_id
BUGSNAG_API_BASE_URL=https://api.bugsnag.com  # Optional, defaults to https://api.bugsnag.com
```

You can also configure these settings in the `config/bugsnag-mcp.php` file:

```php
return [
    'access_token' => env('BUGSNAG_PERSONAL_ACCESS_TOKEN', ''),
    'organization_id' => env('BUGSNAG_ORGANIZATION_ID', ''),
    'project_id' => env('BUGSNAG_PROJECT_ID', ''),
    'api_base_url' => env('BUGSNAG_API_BASE_URL', 'https://api.bugsnag.com'),
];
```

## Installing the MCP Server

After configuration, install the MCP server into your MCP client configuration:

```bash
php artisan bugsnag-mcp:install
```

This command will:
1. Display the configuration snippet needed for your `.mcp.json` or `mcp.json` file
2. Prompt you to automatically write it to the file (if one exists)
3. Optionally write to a specific file using the `--write` option

### Manual Installation

If you prefer to manually add the configuration, add the following to your `.mcp.json` or `mcp.json` file:

```json
{
  "bugsnag": {
    "command": "php",
    "args": ["artisan", "mcp:start", "bugsnag"],
    "cwd": "/path/to/your/laravel/app"
  }
}
```

Replace `/path/to/your/laravel/app` with the absolute path to your Laravel application.

## Usage

### Using with MCP Client

Once configured, the Bugsnag MCP Server will be available as a local MCP server named `bugsnag`. Connect your MCP client to use it.

### Available Tools

#### GetBugsnagError

Fetches detailed information about a specific Bugsnag error, including the most recent event, stack traces, request context, breadcrumbs, and metadata.

**Parameters:**
- `error_id` (string): The Bugsnag error ID to fetch

**Response:**
The tool returns a JSON response containing:
- `error`: Full error details (ID, message, status, severity, etc.)
- `latest_event`: The most recent event for the error with full context
- `instructions_for_copilot`: Suggested analysis steps for AI assistants

**Example:**
```
Tool: GetBugsnagError
Input: {"error_id": "6a0af4dc8c3285d1a53ea587"}

Response:
{
  "error": {
    "id": "6a0af4dc8c3285d1a53ea587",
    "error_class": "InvalidArgumentException",
    "message": "Invalid argument provided",
    "severity": "error",
    "status": "open",
    "events": 5,
    "first_seen": "2026-05-18T11:16:27.688Z",
    "last_seen": "2026-05-20T10:01:34.581Z"
  },
  "latest_event": {
    "id": "3ca351b6-ab75-3d22-9d92-49056734d2fc",
    "context": "GET /api/users",
    "severity": "error",
    "received_at": "2026-05-20T10:01:34.581Z",
    "exceptions": [...],
    "request": {...},
    "breadcrumbs": [...]
  },
  "instructions_for_copilot": [
    "Infer likely root cause.",
    "Suggest local reproduction steps.",
    "Point to likely files to inspect in the Laravel app."
  ]
}
```

## Architecture

### Core Components

- **BugsnagClient**: HTTP client for communicating with the Bugsnag API using Saloon
- **BugsnagServer**: MCP Server definition that exposes tools and resources
- **GetBugsnagError**: Tool for fetching error data
- **Data Models**: Spatie Laravel Data models for type-safe error and event handling

### API Integration

The package uses [Saloon](https://docs.saloon.dev/) for HTTP requests and includes:

- Request/Response classes for each Bugsnag API endpoint
- Automatic DTO transformation using Spatie Laravel Data
- Fixture-based testing with mock responses

## Testing

Run the test suite:

```bash
composer test
```

Run tests with coverage:

```bash
composer test -- --coverage
```

Run linting and static analysis:

```bash
composer lint
```

## Development

### Local Development

Build the workbench:

```bash
composer build
```

Serve the application:

```bash
composer serve
```

### File Structure

```
src/
├── Tools/              # MCP tools
├── Bugsnag/           # Bugsnag API integration
│   ├── Requests/      # Saloon request classes
│   ├── Data/          # DTO models
│   └── BugsnagConnector.php
├── Services/          # Business logic services
├── Providers/         # Laravel service providers
└── BugsnagServer.php  # MCP server definition

tests/
├── Feature/           # Feature tests
├── Integration/       # Integration tests with API
├── Fixtures/          # Mock API responses
└── Support/           # Test utilities
```

## Configuration Reference

### bugsnag-mcp.php

```php
return [
    // Your Bugsnag personal access token
    'access_token' => env('BUGSNAG_PERSONAL_ACCESS_TOKEN', ''),
    
    // Your Bugsnag organization ID
    'organization_id' => env('BUGSNAG_ORGANIZATION_ID', ''),
    
    // Your Bugsnag project ID
    'project_id' => env('BUGSNAG_PROJECT_ID', ''),
    
    // Bugsnag API base URL
    'api_base_url' => env('BUGSNAG_API_BASE_URL', 'https://api.bugsnag.com'),
    
    // Default instructions for Copilot when analyzing errors
    'copilot_instructions' => [
        'Infer likely root cause.',
        'Suggest local reproduction steps.',
        'Point to likely files to inspect in the Laravel app.',
    ],
];
```

## Obtaining Bugsnag Credentials

1. **Personal Access Token**: 
   - Log in to [Bugsnag](https://bugsnag.com/)
   - Navigate to Settings → Personal Access Tokens
   - Create a new token with `read` scope

2. **Organization ID**:
   - Found in your Bugsnag account Settings → Organization

3. **Project ID**:
   - Found in your project's Settings → General

## Troubleshooting

### Missing Configuration

Ensure all required environment variables are set:
- `BUGSNAG_PERSONAL_ACCESS_TOKEN`
- `BUGSNAG_ORGANIZATION_ID`
- `BUGSNAG_PROJECT_ID`

### Authentication Errors

Verify your personal access token is valid and has the required permissions.

### API Connection Issues

Check that:
- Your firewall allows outbound connections to `api.bugsnag.com`
- Your credentials are correct
- The Bugsnag API is accessible

## Contributing

Contributions are welcome! Please feel free to submit pull requests.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

## About

Created by [Dcode Group](https://dcodegroup.com.au/)

## Support

For issues and questions:
- GitHub Issues: [Issues](https://github.com/dcodegroup/bugsnag-laravel-mcp/issues)
- Email: forge@dcodegroup.com.au
