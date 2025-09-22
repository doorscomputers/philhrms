<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestDepartmentAjax extends Command
{
    protected $signature = 'test:department-ajax';

    protected $description = 'Test Department AJAX request directly';

    public function handle()
    {
        $this->info('Testing Department AJAX request...');

        // Test data that will cause validation failure
        $data = [
            'company_id' => 1,
            'code' => 'TOOLONGCODE123', // This will fail validation (>10 chars)
            'name' => 'Test Department',
            'description' => 'Test description',
            'budget_amount' => 50000,
            'max_headcount' => 10,
            'level' => 1,
            'is_active' => true,
        ];

        $this->info('Data to submit (will fail validation):');
        $this->table(['Field', 'Value'], collect($data)->map(function ($value, $key) {
            return [$key, $value];
        })->toArray());

        // First get a CSRF token
        $tokenResponse = Http::get('http://localhost:8000/employees/create');
        $html = $tokenResponse->body();
        preg_match('/<meta name="csrf-token" content="([^"]+)"/', $html, $matches);
        $csrfToken = $matches[1] ?? null;

        if (! $csrfToken) {
            $this->error('Could not extract CSRF token');

            return;
        }

        $this->info("Using CSRF token: {$csrfToken}");

        // Add CSRF token to data
        $data['_token'] = $csrfToken;

        // Make HTTP request to simulate AJAX with proper session
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
            'Referer' => 'http://localhost:8000/employees/create',
        ])->post('http://localhost:8000/departments', $data);

        $this->info("Response Status: {$response->status()}");
        $this->info('Response Headers:');
        foreach ($response->headers() as $header => $values) {
            $this->info("  {$header}: ".implode(', ', $values));
        }

        $this->info('Response Body:');
        $this->info($response->body());

        if ($response->json()) {
            $this->info('JSON Response:');
            $this->table(['Key', 'Value'], collect($response->json())->map(function ($value, $key) {
                return [$key, is_array($value) ? json_encode($value) : $value];
            })->toArray());
        }

        $this->info('Test completed.');
    }
}
