<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagProject extends Data
{
    public function __construct(
        public string $id,
        public string $organization_id,
        public string $slug,
        public string $name,
        public string $type,
        public string $language,
        public string $api_key,
        public int $open_error_count,
        public int $for_review_error_count,
        public int $collaborators_count,
        public int $teams_count,
        public int $custom_event_fields_used,
        public string $url,
        public string $html_url,
        public string $errors_url,
        public string $events_url,
        public string $created_at,
        public string $updated_at,
        public bool $is_full_view,
        public bool $must_use_upload_api_key,
        public bool $ignore_old_browsers,
        public bool $resolve_on_deploy,
        public ?string $performance_display_type = null,
        public ?string $upload_api_key = null,
        public ?string $stability_target_type = null,
        public ?array $global_grouping = null,
        public ?array $location_grouping = null,
        public ?array $discarded_app_versions = null,
        public ?array $discarded_errors = null,
        public ?array $url_whitelist = null,
        public ?array $ignored_browser_versions = null,
        public ?array $release_stages = null,
        public ?array $ecmascript_parse_version = null,
        public ?BugsnagStabilityTarget $target_stability = null,
        public ?BugsnagStabilityTarget $critical_stability = null,
    ) {}
}
