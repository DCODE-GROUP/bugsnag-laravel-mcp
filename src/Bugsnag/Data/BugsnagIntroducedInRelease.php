<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagIntroducedInRelease extends Data
{
    public function __construct(
        public string $release_stage,
        public string $release_id,
        public string $build_label,
    ) {}
}
