<?php

namespace Tests\Fixtures;

use Override;
use Saloon\Data\RecordedResponse;
use Saloon\Http\Faking\Fixture;
use Tests\Support\Traits\SanitizesEvents;

class GetEventFixture extends Fixture
{
    use SanitizesEvents;

    protected function defineName(): string
    {
        return 'bugsnag/get-event';
    }

    protected function defineSensitiveHeaders(): array
    {
        return [
            'Authorization' => 'REDACTED',
        ];
    }

    #[Override]
    protected function beforeSave(RecordedResponse $recordedResponse): RecordedResponse
    {
        $data = json_decode($recordedResponse->data, true);
        $data = $this->sanitizeEventData($data);

        $recordedResponse->data = json_encode($data);

        return $recordedResponse;
    }
}
