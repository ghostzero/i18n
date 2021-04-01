<?php

namespace GhostZero\I18n\Services\SimpleLocalize;

use GhostZero\I18n\Contracts\Service;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;

class SimpleLocalize implements Service
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.simplelocalize.io/api/',
        ]);
    }

    public function upload(array $files, string $locale = 'en'): void
    {
        $response = $this->client->post('v2/import', [
            RequestOptions::QUERY => [
                'uploadFormat' => 'single-language-json',
                'languageKey' => $locale,
            ],
            RequestOptions::HEADERS => [
                'x-simplelocalize-token' => config('i18n.services.simplelocalize.token')
            ],
            RequestOptions::MULTIPART => [
                [
                    'name' => 'file',
                    'contents' => json_encode(Arr::dot($files)),
                    'filename' => 'translations.json',
                ]
            ],
        ]);
    }

    public function download(string $locale = null): array
    {
        $response = $this->client->get('v3/export', [
            RequestOptions::QUERY => [
                'downloadFormat' => 'multi-language-json',
            ],
            RequestOptions::HEADERS => [
                'x-simplelocalize-token' => config('i18n.services.simplelocalize.token'),
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), false);

        return json_decode(file_get_contents($data->data->url), true);
    }
}