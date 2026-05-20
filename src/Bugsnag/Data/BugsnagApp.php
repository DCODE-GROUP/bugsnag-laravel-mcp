<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagApp extends Data
{
    public function __construct(
        public ?string $id = null,
        public ?string $version = null,
        public ?int $versionCode = null,
        public ?string $bundleVersion = null,
        public ?string $codeBundleId = null,
        public ?string $buildUUID = null,
        public ?string $releaseStage = null,
        public ?string $type = null,
        public ?array $dsymUUIDs = null,
        public ?int $duration = null,
        public ?int $durationInForeground = null,
        public ?bool $inForeground = null,
        public ?bool $isLaunching = null,
        public ?string $binaryArch = null,
        public ?bool $runningOnRosetta = null,
    ) {}
}
