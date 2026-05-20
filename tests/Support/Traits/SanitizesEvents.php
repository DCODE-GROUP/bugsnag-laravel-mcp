<?php

namespace Tests\Support\Traits;

trait SanitizesEvents
{
    protected function sanitizeEventData(array $data): array
    {
        $projectId = fake()->uuid();
        $id = fake()->uuid();
        $name = fake()->company();

        data_set($data, 'id', $id);
        data_set($data, 'url', "https://api.bugsnag.com/projects/{$projectId}/events/{$id}");
        data_set($data, 'error_id', fake()->uuid());
        data_set($data, 'context', fake()->randomElement(['GET', 'PATCH', 'POST']).' /'.fake()->slug());

        $origExceptions = data_get($data, 'exceptions', []);
        $newExceptions = [];
        foreach ($origExceptions as $index => $exception) {
            $newExceptions[] = $this->sanitizeException($exception);
            if ($index > 3) { // limit to 4 exceptions to avoid generating too much data
                break;
            }
        }
        data_set($data, 'exceptions', $newExceptions);

        data_set($data, 'request', $this->sanitizeRequest(data_get($data, 'request', [])));
        data_set($data, 'device.hostname', fake()->domainName());
        data_set($data, 'user.id', fake()->uuid());
        data_set($data, 'user.name', fake()->name());
        data_set($data, 'user.email', fake()->email());
        data_set($data, 'breadcrumbs', []);
        data_set($data, 'metaData', [
            'php_version' => phpversion(),
            'app_version' => fake()->semver(),
            'device' => fake()->randomElement(['iPhone 12', 'Samsung Galaxy S21', 'Google Pixel 5']),
            'os_version' => fake()->randomElement(['iOS 14', 'Android 11', 'Windows 10']),
        ]);

        return $data;
    }

    protected function sanitizeRequest(array $request): array
    {
        data_set($request, 'url', fake()->url());
        data_set($request, 'clientIp', fake()->ipv4());
        data_set($request, 'httpMethod', fake()->randomElement(['GET', 'POST', 'PATCH', 'DELETE']));
        data_set($request, 'headers', [
            ['name' => 'User-Agent', 'value' => fake()->userAgent()],
            ['name' => 'Accept', 'value' => fake()->randomElement(['application/json', 'text/html'])],
        ]);
        data_set($request, 'referer', null);
        data_set($request, 'params', null);

        return $request;
    }

    protected function sanitizeException(array $exception): array
    {
        data_set($exception, 'error_class', fake()->randomElement(['ErrorException', 'RuntimeException', 'InvalidArgumentException']));
        data_set($exception, 'message', fake()->sentence());

        $origStacktrace = data_get($exception, 'stacktrace', []);
        $newStacktrace = [];
        foreach ($origStacktrace as $index => $frame) {
            $newStacktrace[] = $this->sanitizeStackFrame($frame);
            if ($index > 5) { // limit to 6 stack frames to avoid generating too much data
                break;
            }
        }
        data_set($exception, 'stacktrace', $newStacktrace);

        data_set($exception, 'metaData', [
            'php_version' => phpversion(),
            'app_version' => fake()->semver(),
            'device' => fake()->randomElement(['iPhone 12', 'Samsung Galaxy S21', 'Google Pixel 5']),
            'os_version' => fake()->randomElement(['iOS 14', 'Android 11', 'Windows 10']),
        ]);

        return $exception;
    }

    protected function sanitizeStackFrame(array $frame): array
    {
        data_set($frame, 'file', '/var/www/html/'.fake()->slug().'.php');
        data_set($frame, 'line_number', fake()->numberBetween(1, 500));
        data_set($frame, 'method', fake()->randomElement(['handle', 'render', 'report']));
        data_set($frame, 'code', [6 => fake()->paragraph()]);

        return $frame;
    }
}
