<?php

namespace App\Console\Commands;

use App\Models\Car;
use Illuminate\Console\Command;

class GenerateCars extends Command
{
    protected $signature = 'cars:generate {--make=} {--model=} {--year_start=} {--year_end=}';
    protected $description = 'Generate car data using Gemini AI';

    public function handle()
    {
        $make = $this->option('make');
        $model = $this->option('model');
        $yearStart = $this->option('year_start');
        $yearEnd = $this->option('year_end');

        if (!$make || !$model) {
            $this->error('Use: php artisan cars:generate --make=Toyota --model=Camry --year_start=2007 --year_end=2011');
            return;
        }

        $this->info("Generating {$make} {$model} ({$yearStart}-{$yearEnd})...");

        $prompt = "Return ONLY valid JSON for a {$make} {$model} {$yearStart}-{$yearEnd} GCC/Middle East spec car:
{
    \"engine_type\": \"e.g. 2.4L I4\",
    \"horsepower\": 158,
    \"zero_to_100_kmh\": 8.5,
    \"top_speed_kmh\": 210,
    \"transmission\": \"automatic or manual or cvt\",
    \"gears\": 5,
    \"drivetrain\": \"FWD or RWD or AWD or 4WD\",
    \"fuel_type\": \"petrol or diesel or hybrid\",
    \"body_type\": \"sedan or suv or coupe or hatchback\",
    \"oil_capacity_l\": 4.3,
    \"oil_density_type\": \"5W-30\",
    \"hydraulic_capacity_l\": 1.0,
    \"hydraulic_fluid_type\": \"Toyota T-IV ATF\",
    \"fuel_combined_l_100km\": 8.5,
    \"fuel_city_l_100km\": 10.0,
    \"fuel_highway_l_100km\": 7.0,
    \"description_en\": \"English description\",
    \"description_ku\": \"Sorani Kurdish description\"
}";

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

        if ($httpCode === 429) {
            $this->error("Rate limited. Try again later.");
            return;
        }

        if ($httpCode !== 200) {
            $this->error("HTTP Error: {$httpCode}");
            return;
        }

        $response = json_decode($result, true);
        $text = $response['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if ($text) {
            $text = str_replace(['```json', '```'], '', $text);
            $data = json_decode(trim($text), true);

            if ($data) {
                Car::create([
                    'make' => $make,
                    'model' => $model,
                    'year' => $yearStart,
                    'year_start' => $yearStart,
                    'year_end' => $yearEnd,
                    'region' => 'GCC',
                    'engine_type' => $data['engine_type'] ?? null,
                    'horsepower' => $data['horsepower'] ?? null,
                    'zero_to_100_kmh' => $data['zero_to_100_kmh'] ?? null,
                    'top_speed_kmh' => $data['top_speed_kmh'] ?? null,
                    'transmission' => $data['transmission'] ?? null,
                    'gears' => $data['gears'] ?? null,
                    'drivetrain' => $data['drivetrain'] ?? null,
                    'fuel_type' => $data['fuel_type'] ?? null,
                    'body_type' => $data['body_type'] ?? null,
                    'oil_capacity_l' => $data['oil_capacity_l'] ?? null,
                    'oil_density_type' => $data['oil_density_type'] ?? null,
                    'hydraulic_capacity_l' => $data['hydraulic_capacity_l'] ?? null,
                    'hydraulic_fluid_type' => $data['hydraulic_fluid_type'] ?? null,
                    'fuel_combined_l_100km' => $data['fuel_combined_l_100km'] ?? null,
                    'fuel_city_l_100km' => $data['fuel_city_l_100km'] ?? null,
                    'fuel_highway_l_100km' => $data['fuel_highway_l_100km'] ?? null,
                    'description_en' => $data['description_en'] ?? null,
                    'description_ku' => $data['description_ku'] ?? null,
                    'image_path' => 'cars/placeholder',
                ]);
                $this->info("✅ {$make} {$model} ({$yearStart}-{$yearEnd}) added!");
            } else {
                $this->error("Failed to parse JSON");
            }
        }
    }
}