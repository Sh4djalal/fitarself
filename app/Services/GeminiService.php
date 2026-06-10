<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
    }

    public function generateFaultCodeInfo($code, $make)
    {
        $prompt = "OBD-II code {$code} for {$make}. Return ONLY valid JSON with ALL fields in BOTH English and Sorani Kurdish. Do NOT skip any field:
{
\"title\":\"English title\",
\"description\":\"English description\",
\"symptoms\":\"English symptoms each on new line\",
\"possible_causes\":\"English causes each on new line\",
\"how_to_fix\":\"English fix steps each on new line\",
\"severity\":\"low/medium/high/critical\",
\"system\":\"Engine/Transmission/Brakes/etc\",
\"title_ku\":\"Sorani Kurdish title\",
\"description_ku\":\"Sorani Kurdish description\",
\"symptoms_ku\":\"Sorani Kurdish symptoms each on new line\",
\"possible_causes_ku\":\"Sorani Kurdish causes each on new line\",
\"how_to_fix_ku\":\"Sorani Kurdish fix steps each on new line\"
}";

        $response = Http::withoutVerifying()
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [['parts' => [['text' => $prompt]]]],
            ]);

        if ($response->status() === 429) {
            echo " (Rate limited, waiting 60s...) ";
            sleep(60);
            return $this->generateFaultCodeInfo($code, $make);
        }

        if ($response->successful()) {
            $text = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if ($text) {
                $text = str_replace(['```json', '```'], '', $text);
                return json_decode(trim($text), true);
            }
        }
        return null;
    }
}