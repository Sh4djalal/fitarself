<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ImageSearchService
{
    private $apiKey;
    private $searchEngineId;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_API_KEY');
        $this->searchEngineId = env('GOOGLE_SEARCH_ENGINE_ID');
    }

    public function searchImage($query)
    {
        $cacheKey = 'image_' . md5($query);

        return Cache::remember($cacheKey, 86400, function () use ($query) {
            $response = Http::get('https://www.googleapis.com/customsearch/v1', [
                'key' => $this->apiKey,
                'cx' => $this->searchEngineId,
                'q' => $query,
                'searchType' => 'image',
                'num' => 3,
                'imgSize' => 'medium',
                'safe' => 'active',
            ]);

            // Debug
            if (!$response->successful()) {
                \Log::error('Google Image Search Error: ' . $response->body());
                return [];
            }

            $items = $response->json()['items'] ?? [];
            $images = [];
            foreach ($items as $item) {
                $images[] = [
                    'url' => $item['link'] ?? '',
                    'thumbnail' => $item['image']['thumbnailLink'] ?? '',
                    'title' => $item['title'] ?? '',
                ];
            }
            return $images;
        });
    }
}
