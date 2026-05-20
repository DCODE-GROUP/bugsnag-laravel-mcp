<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagStabilityTarget extends Data
{
    public function __construct(
        public float $value,
        public ?string $updated_at = null,
        public ?string $updated_by_id = null,
    ) {}
}
