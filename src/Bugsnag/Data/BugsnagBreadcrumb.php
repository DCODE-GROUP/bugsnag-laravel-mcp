<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagBreadcrumb extends Data
{
    public function __construct(
        public string $name,
        public string $type,
        public string $timestamp,
        public ?array $metaData = null,
    ) {}
}
