<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagCorrelation extends Data
{
    public function __construct(
        public ?string $traceId = null,
        public ?string $spanId = null,
    ) {}
}
