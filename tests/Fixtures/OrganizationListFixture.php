<?php

namespace Tests\Fixtures;

use Override;
use Saloon\Data\RecordedResponse;
use Saloon\Http\Faking\Fixture;

class OrganizationListFixture extends Fixture
{
    protected function defineName(): string
    {
        return 'bugsnag/list-organizations';
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
        $company = fake()->company();
        $organizationId = fake()->uuid();
        data_set($data, 'name', $company);
        data_set($data, 'slug', strtolower(str_replace(' ', '-', $company)));
        data_set($data, 'id', $organizationId);
        data_set($data, 'api_key', 'REDACTED');
        data_set($data, 'creator', [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'id' => fake()->uuid(),
        ]);
        data_set($data, 'billing_emails', [fake()->email()]);
        data_set($data, 'collaborators_url', "https://api.bugsnag.com/organizations/{$organizationId}/collaborators");
        data_set($data, 'projects_url', "https://api.bugsnag.com/organizations/{$organizationId}/projects");
        data_set($data, 'upgrade_url', "https://app.bugsnag.com/settings/{$organizationId}/upgrade");

        return $data;
    }
}
