<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagOrganization extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string $slug,
        public string $api_key,
        public bool $auto_upgrade,
        public ?BugsnagCreator $creator = null,
        public ?array $billing_emails = null,
        public ?string $collaborators_url = null,
        public ?string $projects_url = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
        public ?string $upgrade_url = null,
        public bool $managed_by_platform_services = false,
    ) {}
}
