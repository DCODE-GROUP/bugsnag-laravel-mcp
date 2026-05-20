<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagCreator extends Data
{
    public function __construct(
        public string $id,
        public string $email,
        public string $name,
    ) {}
}
