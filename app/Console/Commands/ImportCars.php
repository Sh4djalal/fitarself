<?php

namespace App\Console\Commands;

use App\Models\Car;
use Illuminate\Console\Command;

class ImportCars extends Command
{
    protected $signature = 'cars:import';
    protected $description = 'Import cars from CSV file';

    public function handle()
    {
        $file = base_path('cars.csv');
        
        if (!file_exists($file)) {
            $this->error('cars.csv not found!');
            return;
        }

        Car::where('id', '>', 6)->delete();
        
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle);
        
        $count = 0;
        $skipped = 0;
        $this->info('Importing cars...');

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            
            $make = $data['MAKE'] ?? 'Unknown';
            $model = $data['MODEL'] ?? 'Unknown';
            $year = intval($data['YEAR'] ?? 2020);
            $vehicleClass = $data['VEHICLE CLASS'] ?? null;
            $engine = $data['ENGINE SIZE'] ?? null;
            $cylinders = $data['CYLINDERS'] ?? null;
            $transRaw = $data['TRANSMISSION'] ?? '';
            $fuelRaw = strtolower($data['FUEL'] ?? '');
            $fuelCity = floatval($data['FUEL CONSUMPTION'] ?? 0);
            $fuelHighway = floatval($data['HWY (L/100 km)'] ?? 0);
            $fuelCombined = floatval($data['COMB (L/100 km)'] ?? 0);
            
            // Map transmission
            $transmission = null;
            if (stripos($transRaw, 'A') !== false || stripos($transRaw, 'auto') !== false) {
                $transmission = 'automatic';
            } elseif (stripos($transRaw, 'M') !== false || stripos($transRaw, 'manual') !== false) {
                $transmission = 'manual';
            }
            
            // Map fuel type
            $fuelType = null;
            if (str_contains($fuelRaw, 'x') || str_contains($fuelRaw, 'regular') || str_contains($fuelRaw, 'premium')) {
                $fuelType = 'petrol';
            } elseif (str_contains($fuelRaw, 'diesel')) {
                $fuelType = 'diesel';
            } elseif (str_contains($fuelRaw, 'electric')) {
                $fuelType = 'electric';
            } elseif (str_contains($fuelRaw, 'hybrid')) {
                $fuelType = 'hybrid';
            }
            
            // Map body type
            $bodyType = match(strtolower($vehicleClass ?? '')) {
                'suv', 'suv: small', 'suv: standard' => 'suv',
                'sedan', 'compact', 'mid-size', 'full-size' => 'sedan',
                'coupe' => 'coupe',
                'hatchback' => 'hatchback',
                'truck', 'pickup truck', 'pickup truck: standard' => 'truck',
                'van', 'minivan', 'van: passenger' => 'van',
                'wagon', 'station wagon', 'station wagon: small', 'station wagon: mid-size' => 'wagon',
                default => null,
            };
            
            $engineDesc = $engine ? trim($engine . 'L ' . ($cylinders ?? '')) : null;
            
            try {
                Car::create([
                    'make' => $make,
                    'model' => $model,
                    'year' => $year > 1900 ? $year : 2020,
                    'engine_type' => $engineDesc,
                    'transmission' => $transmission,
                    'fuel_type' => $fuelType,
                    'body_type' => $bodyType,
                    'fuel_city_l_100km' => $fuelCity > 0 ? $fuelCity : null,
                    'fuel_highway_l_100km' => $fuelHighway > 0 ? $fuelHighway : null,
                    'fuel_combined_l_100km' => $fuelCombined > 0 ? $fuelCombined : null,
                    'image_path' => 'cars/placeholder',
                ]);
                $count++;
            } catch (\Exception $e) {
                $skipped++;
            }
            
            if ($count % 1000 === 0) {
                $this->info("Imported {$count} cars...");
            }
        }
        
        fclose($handle);
        $this->info("Done! {$count} cars imported, {$skipped} skipped.");
    }
}