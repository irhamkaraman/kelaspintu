<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PistonService
{
    protected $client;
    protected $baseUrl = 'https://emkc.org/api/v2/piston';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Map internal languages to Piston runtimes
     */
    protected function getLanguageConfig($language)
    {
        // maps to [language, version]
        $map = [
            'c' => ['language' => 'c', 'version' => '10.2.0'],
            'cpp' => ['language' => 'c++', 'version' => '10.2.0'],
            'java' => ['language' => 'java', 'version' => '15.0.2'],
            'python' => ['language' => 'python', 'version' => '3.10.0'],
            'php' => ['language' => 'php', 'version' => '8.2.3'],
            'javascript' => ['language' => 'javascript', 'version' => '18.15.0'],
        ];

        return $map[$language] ?? ['language' => 'python', 'version' => '3.10.0'];
    }

    /**
     * Submit code untuk dieksekusi via Piston API
     */
    public function executeCode($code, $language, $stdin = null)
    {
        $config = $this->getLanguageConfig($language);

        $payload = [
            'language' => $config['language'],
            'version' => $config['version'],
            'files' => [
                [
                    'content' => $code
                ]
            ],
            'stdin' => $stdin ?? '',
        ];

        try {
            $response = $this->client->post("{$this->baseUrl}/execute", [
                'json' => $payload,
            ]);

            $result = json_decode($response->getBody(), true);
            return $result;

        } catch (\Exception $e) {
            Log::error('Piston execution failed: ' . $e->getMessage());
            throw new \Exception('Failed to execute code: ' . $e->getMessage());
        }
    }
}
