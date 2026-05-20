<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagRequest extends Data
{
    public function __construct(
        public ?string $url = null,
        public ?string $clientIp = null,
        public ?string $httpMethod = null,
        public ?string $referer = null,
        public ?array $headers = null,
        public ?array $params = null,
    ) {}
}
