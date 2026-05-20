<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagDevice extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $hostname = null,
        public ?string $manufacturer = null,
        public ?string $model = null,
        public ?string $modelNumber = null,
        public ?string $osName = null,
        public ?string $osVersion = null,
        public ?int $freeMemory = null,
        public ?int $totalMemory = null,
        public ?int $freeDisk = null,
        public ?string $browserName = null,
        public ?string $browserVersion = null,
        public ?bool $jailbroken = null,
        public ?string $orientation = null,
        public ?string $locale = null,
        public ?bool $charging = null,
        public ?float $batteryLevel = null,
        public ?string $time = null,
        public ?string $timezone = null,
        public ?array $cpuAbi = null,
        public ?array $runtimeVersions = null,
        public ?string $macCatalystIosVersion = null,
    ) {}
}
