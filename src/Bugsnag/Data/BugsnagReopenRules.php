<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagReopenRules extends Data
{
    public function __construct(
        public string $reopen_if,
        public ?int $additional_users = null,
        public ?string $reopen_after = null,
        public ?int $seconds = null,
        public ?int $occurrences = null,
        public ?int $hours = null,
        public ?int $occurrence_threshold = null,
        public ?int $additional_occurrences = null,
    ) {}
}
