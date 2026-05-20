<?php

namespace Dcodegroup\BugsnagLaravelMcp\Bugsnag\Data;

use Spatie\LaravelData\Data;

class BugsnagError extends Data
{
    public function __construct(
        public string $id,
        public string $project_id,
        public string $url,
        public string $project_url,
        public string $error_class,
        public string $message,
        public string $severity,
        public int $events,
        public string $events_url,
        public int $unthrottled_occurrence_count,
        public int $users,
        public string $first_seen,
        public string $last_seen,
        public string $first_seen_unfiltered,
        public string $last_seen_unfiltered,
        public string $status,
        public int $comment_count,
        public bool $discarded,
        public ?string $context = null,
        public ?string $assigned_collaborator_id = null,
        public ?string $assigned_team_id = null,
        public ?string $original_severity = null,
        public ?string $overridden_severity = null,
        public ?array $trend = null,
        public ?BugsnagReopenRules $reopen_rules = null,
        /** @var BugsnagLinkedIssue[] */
        public ?array $linked_issues = null,
        public ?array $created_issue = null,
        public ?array $missing_dsyms = null,
        public ?array $release_stages = null,
        public ?string $grouping_reason = null,
        public ?array $grouping_fields = null,
        /** @var BugsnagIntroducedInRelease[] */
        public ?array $introduced_in_releases = null,
    ) {}
}
