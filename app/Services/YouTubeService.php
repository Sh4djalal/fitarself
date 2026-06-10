<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class YouTubeService
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('YOUTUBE_API_KEY');
    }

    public function searchVideos($query, $maxResults = 3)
    {
        $response = Http::get('https://www.googleapis.com/youtube/v3/search', [
            'key' => $this->apiKey,
            'q' => $query,
            'part' => 'snippet',
            'type' => 'video',
            'maxResults' => $maxResults,
            'relevanceLanguage' => 'en',
        ]);

        if ($response->successful()) {
            $videoIds = collect($response->json()['items'])->pluck('id.videoId')->implode(',');
            
            if ($videoIds) {
                $detailsResponse = Http::get('https://www.googleapis.com/youtube/v3/videos', [
                    'key' => $this->apiKey,
                    'id' => $videoIds,
                    'part' => 'snippet,contentDetails',
                ]);

                if ($detailsResponse->successful()) {
                    return collect($detailsResponse->json()['items'])->map(function ($video) {
                        return [
                            'id' => $video['id'],
                            'title' => $video['snippet']['title'],
                            'thumbnail' => $video['snippet']['thumbnails']['medium']['url'] ?? $video['snippet']['thumbnails']['default']['url'],
                            'duration' => $this->formatDuration($video['contentDetails']['duration']),
                            'url' => 'https://www.youtube.com/watch?v=' . $video['id'],
                        ];
                    })->toArray();
                }
            }
        }

        return [];
    }

    private function formatDuration($isoDuration)
    {
        $interval = new \DateInterval($isoDuration);
        if ($interval->h > 0) {
            return $interval->h . ':' . str_pad($interval->i, 2, '0', STR_PAD_LEFT) . ':' . str_pad($interval->s, 2, '0', STR_PAD_LEFT);
        }
        return $interval->i . ':' . str_pad($interval->s, 2, '0', STR_PAD_LEFT);
    }
}