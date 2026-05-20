<?php

namespace Tests\Fixtures;

use Override;
use Saloon\Data\RecordedResponse;
use Saloon\Http\Faking\Fixture;
use Tests\Support\Traits\SanitizesEvents;

class GetErrorFixture extends Fixture
{
    use SanitizesEvents;

    protected function defineName(): string
    {
        return 'bugsnag/get-error';
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

        $id = fake()->uuid();
        $projectId = fake()->uuid();

        data_set($data, 'id', $id);
        data_set($data, 'project_id', $projectId);
        data_set($data, 'url', 'https://app.bugsnag.com/projects/'.$projectId.'/errors/'.$id);
        data_set($data, 'project_url', 'https://app.bugsnag.com/projects/'.$projectId);
        data_set($data, 'error_class', 'Exception');
        data_set($data, 'message', 'Exception: Something went wrong');
        data_set($data, 'events_url', 'https://api.bugsnag.com/projects/'.$projectId.'/errors/'.$id.'/events');
        data_set($data, 'context', fake()->randomElement(['POST', 'GET', 'PUT', 'DELETE']).' /'.fake()->slug());
        data_set($data, 'grouping_fields', []);
        data_set($data, 'introduced_in_releases', [[
            'release_stage' => fake()->randomElement(['production', 'staging', 'development']),
            'release_id' => fake()->uuid(),
            'build_label' => fake()->semver(),
        ]]);

        $recordedResponse->data = json_encode($data);

        return $recordedResponse;
    }
}
