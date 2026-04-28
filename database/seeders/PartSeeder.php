<?php

namespace Database\Seeders;

use App\Models\Part;
use App\Models\User;
use Illuminate\Database\Seeder;

class PartSeeder extends Seeder
{
    public function run(): void
    {
        // Get mechanic IDs
        $ahmad = User::where('email', 'ahmad@fitarself.com')->first();
        $sara = User::where('email', 'sara@fitarself.com')->first();
        $dana = User::where('email', 'dana@fitarself.com')->first();

        $parts = [
            [
                'name_en' => 'High Performance Brake Pads', 'name_ku' => 'پێلی برێکی بەرز',
                'category' => 'brakes', 'price' => 45000, 'brand' => 'Brembo',
                'part_number' => 'BR-P4567', 'condition' => 'new', 'stock_quantity' => 25,
                'seller_id' => $dana->id,
                'compatible_cars' => json_encode(['Toyota Camry 2018-2024', 'Toyota Corolla 2019-2024']),
                'description_en' => 'Premium ceramic brake pads for superior stopping power. Sold by BrakeMaster Center.'
            ],
            [
                'name_en' => 'Engine Oil Filter', 'name_ku' => 'فیلتەری ڕۆنی مەکینە',
                'category' => 'oil', 'price' => 12000, 'brand' => 'Bosch',
                'part_number' => 'BO-F8901', 'condition' => 'new', 'stock_quantity' => 50,
                'seller_id' => $ahmad->id,
                'compatible_cars' => json_encode(['Toyota Supra 2020-2024', 'BMW M4 2021-2024']),
                'description_en' => 'High-quality oil filter for maximum engine protection. Sold by AutoPro Workshop.'
            ],
            [
                'name_en' => 'Spark Plug Set (4 pcs)', 'name_ku' => 'سێتی پڵگی فیشەر (٤ دانە)',
                'category' => 'engine', 'price' => 35000, 'brand' => 'NGK',
                'part_number' => 'NGK-SP1234', 'condition' => 'new', 'stock_quantity' => 30,
                'seller_id' => $ahmad->id,
                'compatible_cars' => json_encode(['Honda Civic 2020-2024', 'Ford Mustang 2019-2024']),
                'description_en' => 'Iridium spark plugs for improved fuel efficiency. Sold by AutoPro Workshop.'
            ],
            [
                'name_en' => 'Shock Absorber - Front', 'name_ku' => 'شۆک ئەبزۆربەری پێشەوە',
                'category' => 'suspension', 'price' => 85000, 'brand' => 'KYB',
                'part_number' => 'KYB-SA5678', 'condition' => 'new', 'stock_quantity' => 15,
                'seller_id' => $dana->id,
                'compatible_cars' => json_encode(['Mercedes C-Class 2020-2024', 'BMW 3 Series 2019-2024']),
                'description_en' => 'OEM quality shock absorber for smooth ride. Sold by BrakeMaster Center.'
            ],
            [
                'name_en' => 'LED Headlight Bulb Kit', 'name_ku' => 'کیتی گڵۆپی سەری LED',
                'category' => 'electrical', 'price' => 28000, 'brand' => 'Philips',
                'part_number' => 'PH-HL9001', 'condition' => 'new', 'stock_quantity' => 40,
                'seller_id' => $sara->id,
                'compatible_cars' => json_encode(['Universal - Most Cars']),
                'description_en' => 'Bright white LED headlights, easy plug-and-play install. Sold by ElectroFix Garage.'
            ],
            [
                'name_en' => 'Used Engine - Toyota 2.5L', 'name_ku' => 'مەکینەی بەکارهاتوو - تۆیۆتا ٢.٥ لیتر',
                'category' => 'engine', 'price' => 750000, 'brand' => 'Toyota OEM',
                'part_number' => 'TO-ENG-25', 'condition' => 'used', 'stock_quantity' => 3,
                'seller_id' => $ahmad->id,
                'compatible_cars' => json_encode(['Toyota Camry 2018-2022']),
                'description_en' => 'Tested used engine in good condition. 60,000 km mileage. Sold by AutoPro Workshop.'
            ],
        ];

        foreach ($parts as $part) {
            Part::create($part);
        }
    }
}