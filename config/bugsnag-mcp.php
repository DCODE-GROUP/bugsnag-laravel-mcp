<?php

return [
    'access_token' => env('BUGSNAG_PERSONAL_ACCESS_TOKEN', ''),
    'organization_id' => env('BUGSNAG_ORGANIZATION_ID', ''),
    'project_id' => env('BUGSNAG_PROJECT_ID', ''),
    'api_base_url' => env('BUGSNAG_API_BASE_URL', 'https://api.bugsnag.com'),
    'copilot_instructions' => [
        'Infer likely root cause.',
        'Suggest local reproduction steps.',
        'Point to likely files to inspect in the Laravel app.',
    ],
];
