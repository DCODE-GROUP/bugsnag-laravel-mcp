<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagFeatureFlag extends Data
{
    public function __construct(
        public string $feature_flag_name,
        public ?string $feature_flag_id = null,
        public ?string $variant_name = null,
        public ?string $variant_id = null,
    ) {}
}
