<?php

namespace App\Console\Commands;

use App\Models\FaultCode;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TranslateFaultCodes extends Command
{
    protected $signature = 'faults:translate';
    protected $description = 'Translate fault codes to Kurdish';

    public function handle()
    {
        $code = FaultCode::where('symptoms_ku', 'like', '%Check Engine%')->first();
        
        if (!$code) {
            $this->info("All codes already translated!");
            return;
        }

        $this->info("Translating {$code->code}...");

        $prompt = "Translate to Sorani Kurdish. Return ONLY JSON: {\"symptoms_ku\":\"{$code->symptoms_en}\",\"causes_ku\":\"{$code->possible_causes_en}\"}";

        $response = Http::withoutVerifying()
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=' . env('GEMINI_API_KEY'), [
                'contents' => [['parts' => [['text' => $prompt]]]],
            ]);

        if ($response->successful()) {
            $text = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
            $this->info("Raw: " . $text);
            
            if ($text) {
                $text = str_replace(['```json', '```'], '', $text);
                $data = json_decode(trim($text), true);
                if ($data) {
                    $code->symptoms_ku = $data['symptoms_ku'] ?? $code->symptoms_en;
                    $code->possible_causes_ku = $data['causes_ku'] ?? $code->possible_causes_en;
                    $code->save();
                    $this->info("✓ Translated!");
                } else {
                    $this->warn("JSON parse failed");
                }
            }
        } else {
            $this->error("API error: " . $response->status());
        }
    }
}