<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data;

class BugsnagException extends Data
{
    public function __construct(
        #[MapName('error_class')]
        public string $errorClass,
        public string $message,
        /** @var BugsnagStackFrame[] */
        public ?array $stacktrace = null,
        public ?string $type = null,
        public ?array $registers = null,
    ) {}
}
