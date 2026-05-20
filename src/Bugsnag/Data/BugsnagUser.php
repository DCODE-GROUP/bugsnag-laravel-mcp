<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagUser extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $email = null,
    ) {}
}
