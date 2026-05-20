<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagThread extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $type,
        /** @var BugsnagStackFrame[] */
        public ?array $stacktrace = null,
        public ?bool $error_reporting_thread = null,
        public ?string $state = null,
    ) {}
}
