<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagStackFrame extends Data
{
    public function __construct(
        public ?int $line_number = null,
        public ?string $column_number = null,
        public ?string $file = null,
        public ?bool $in_project = null,
        public ?string $code_file = null,
        public ?string $address_offset = null,
        public ?string $macho_uuid = null,
        public ?string $relative_address = null,
        public ?string $frame_address = null,
        public ?string $method = null,
        public ?string $source_control_link = null,
        public ?string $source_control_name = null,
        public ?bool $inlined = null,
        public ?array $code = null,
    ) {}
}
