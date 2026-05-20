<?php

namespace Tests\Fixtures;

use Override;
use Saloon\Data\RecordedResponse;
use Saloon\Http\Faking\Fixture;

class ProjectListFixture extends Fixture
{
    protected function defineName(): string
    {
        return 'bugsnag/list-projects';
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
        foreach ($data as $index => $item) {
            $data[$index] = $this->sanitizeFixtureData($item);
        }

        $recordedResponse->data = json_encode($data);

        return $recordedResponse;
    }

    protected function sanitizeFixtureData(array $data): array
    {
        $organizationId = fake()->uuid();
        $id = fake()->uuid();
        $name = fake()->company();

        data_set($data, 'id', $id);
        data_set($data, 'organization_id', $organizationId);
        data_set($data, 'name', $name);
        data_set($data, 'slug', $slug = strtolower(str_replace(' ', '-', $name)));
        data_set($data, 'api_key', 'REDACTED');
        data_set($data, 'upload_api_key', 'REDACTED');
        data_set($data, 'errors_url', "https://api.bugsnag.com/projects/{$id}/errors");
        data_set($data, 'events_url', "https://api.bugsnag.com/projects/{$id}/events");
        data_set($data, 'url', "https://app.bugsnag.com/projects/{$id}");
        data_set($data, 'html_url', "https://app.bugsnag.com/{$slug}");

        return $data;
    }
}
