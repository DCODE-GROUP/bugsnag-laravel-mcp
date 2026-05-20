<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagLinkedIssue extends Data
{
    public function __construct(
        public string $id,
        public string $type,
        public string $url,
        public ?string $key = null,
        public ?int $number = null,
    ) {}
}
