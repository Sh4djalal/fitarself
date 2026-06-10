<?php

namespace App\Console\Commands;

use App\Models\FaultCode;
use Illuminate\Console\Command;

class GenerateCodeList extends Command
{
    protected $signature = 'faults:codes {--make=}';
    protected $description = 'Import fault codes from Gemini (loops until done)';

    public function handle()
    {
        $make = $this->option('make');
        if (!$make) { $this->error('Use --make=Toyota'); return; }

        $totalAdded = 0;
        $rounds = 0;

        while ($rounds < 10) {
            $rounds++;
            $this->info("Round {$rounds}...");

            $existing = FaultCode::where('make', $make)->pluck('code')->toArray();
            $existingList = !empty($existing) ? "EXCLUDE: " . implode(',', $existing) . ". " : "";
            
            $prompt = $existingList . "List OBD-II codes for {$make}. Return ONLY JSON array: [{\"code\":\"P0100\",\"title\":\"Mass Air Flow Circuit\"},...]. Give 50+ codes NOT in the exclude list.";

            $apiKey = env('GEMINI_API_KEY');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['contents' => [['parts' => [['text' => $prompt]]]]]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 429) { $this->warn("Rate limited. Waiting 30s..."); sleep(30); continue; }
            if ($httpCode !== 200) { $this->error("HTTP {$httpCode}"); break; }

            $response = json_decode($result, true);
            $text = $response['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if (!$text) break;

            $text = str_replace(['```json', '```'], '', $text);
            $codes = json_decode(trim($text), true);
            if (!$codes) break;

            $added = 0;
            foreach ($codes as $c) {
                if (!FaultCode::where('code', $c['code'])->where('make', $make)->exists()) {
                    FaultCode::create([
                        'code' => $c['code'], 'code_type' => $c['code'][0] ?? 'P',
                        'make' => $make, 'title_en' => $c['title'] ?? $c['code'],
                        'severity' => 'medium', 'system' => 'General',
                    ]);
                    $added++; $totalAdded++;
                }
            }
            $this->info("+{$added} codes. Total: {$totalAdded}");
            if ($added < 5) break;
            sleep(5);
        }
        $this->info("Done! {$make}: " . FaultCode::where('make', $make)->count() . " codes.");
    }
}