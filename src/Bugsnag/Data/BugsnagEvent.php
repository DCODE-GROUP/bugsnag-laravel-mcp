<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagEvent extends Data
{
    public function __construct(
        public string $id,
        public string $url,
        public string $project_url,
        public bool $is_full_report,
        public string $error_id,
        public string $received_at,
        public string $context,
        public string $severity,
        public bool $unhandled,
        /** @var BugsnagException[] */
        public ?array $exceptions = null,
        /** @var BugsnagThread[] */
        public ?array $threads = null,
        public ?array $metaData = null,
        public ?BugsnagRequest $request = null,
        public ?BugsnagApp $app = null,
        public ?BugsnagDevice $device = null,
        public ?BugsnagUser $user = null,
        /** @var BugsnagBreadcrumb[] */
        public ?array $breadcrumbs = null,
        public ?bool $missing_dsym = null,
        public ?BugsnagCorrelation $correlation = null,
        /** @var BugsnagFeatureFlag[] */
        public ?array $feature_flags = null,
    ) {}
}
