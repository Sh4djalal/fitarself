<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        

        $cars = [
            [
                'make' => 'Toyota', 'model' => 'Supra', 'year' => 2024, 'trim' => 'GR 3.0 Turbo',
                'engine_type' => '3.0L Turbo I6', 'horsepower' => 382,
                'zero_to_100_kmh' => 3.9, 'top_speed_kmh' => 250,
                'transmission' => 'automatic', 'gears' => 8, 'drivetrain' => 'RWD',
                'fuel_type' => 'petrol', 'body_type' => 'coupe',
                'oil_capacity_l' => 6.5, 'oil_density_type' => '0W-20 / 5W-30',
                'hydraulic_capacity_l' => 1.2, 'hydraulic_fluid_type' => 'CHF 11S',
                'fuel_combined_l_100km' => 8.5, 'fuel_city_l_100km' => 10.2, 'fuel_highway_l_100km' => 6.8,
                'image_path' => 'cars/toyota-supra',
                'description_en' => 'The legendary Toyota GR Supra returns with a 3.0L turbocharged inline-6.'
            ],
            [
                'make' => 'Toyota', 'model' => 'Camry', 'year' => 2024, 'trim' => 'XSE V6',
                'engine_type' => '3.5L V6', 'horsepower' => 301,
                'zero_to_100_kmh' => 5.8, 'top_speed_kmh' => 220,
                'transmission' => 'automatic', 'gears' => 8, 'drivetrain' => 'FWD',
                'fuel_type' => 'petrol', 'body_type' => 'sedan',
                'oil_capacity_l' => 4.7, 'oil_density_type' => '0W-20',
                'hydraulic_capacity_l' => 1.0, 'hydraulic_fluid_type' => 'Dexron VI',
                'fuel_combined_l_100km' => 7.4, 'fuel_city_l_100km' => 9.0, 'fuel_highway_l_100km' => 6.2,
                'image_path' => 'cars/toyota-camry',
                'description_en' => 'The Toyota Camry combines comfort, reliability, and sporty performance.'
            ],
            [
                'make' => 'BMW', 'model' => 'M4 Competition', 'year' => 2024, 'trim' => 'xDrive',
                'engine_type' => '3.0L Twin-Turbo I6', 'horsepower' => 503,
                'zero_to_100_kmh' => 3.5, 'top_speed_kmh' => 290,
                'transmission' => 'automatic', 'gears' => 8, 'drivetrain' => 'AWD',
                'fuel_type' => 'petrol', 'body_type' => 'coupe',
                'oil_capacity_l' => 7.0, 'oil_density_type' => '0W-30 / 5W-30',
                'hydraulic_capacity_l' => 1.3, 'hydraulic_fluid_type' => 'CHF 11S',
                'fuel_combined_l_100km' => 10.1, 'fuel_city_l_100km' => 12.5, 'fuel_highway_l_100km' => 7.8,
                'image_path' => 'cars/bmw-m4',
                'description_en' => 'The BMW M4 Competition xDrive delivers breathtaking performance with 503 hp.'
            ],
            [
                'make' => 'Mercedes-Benz', 'model' => 'C 63 S', 'year' => 2024, 'trim' => 'AMG E Performance',
                'engine_type' => '2.0L Turbo Hybrid', 'horsepower' => 671,
                'zero_to_100_kmh' => 3.4, 'top_speed_kmh' => 280,
                'transmission' => 'automatic', 'gears' => 9, 'drivetrain' => 'AWD',
                'fuel_type' => 'hybrid', 'body_type' => 'sedan',
                'oil_capacity_l' => 5.5, 'oil_density_type' => '0W-40',
                'hydraulic_capacity_l' => 1.1, 'hydraulic_fluid_type' => 'MB 345.0',
                'fuel_combined_l_100km' => 6.9, 'fuel_city_l_100km' => 8.0, 'fuel_highway_l_100km' => 6.0,
                'image_path' => 'cars/mercedes-c63',
                'description_en' => 'The Mercedes-AMG C 63 S E Performance combines F1 hybrid technology.'
            ],
            [
                'make' => 'Honda', 'model' => 'Civic Type R', 'year' => 2024, 'trim' => 'FL5',
                'engine_type' => '2.0L Turbo I4', 'horsepower' => 315,
                'zero_to_100_kmh' => 5.4, 'top_speed_kmh' => 272,
                'transmission' => 'manual', 'gears' => 6, 'drivetrain' => 'FWD',
                'fuel_type' => 'petrol', 'body_type' => 'hatchback',
                'oil_capacity_l' => 5.0, 'oil_density_type' => '0W-20',
                'hydraulic_capacity_l' => 0.9, 'hydraulic_fluid_type' => 'Honda MTF',
                'fuel_combined_l_100km' => 8.2, 'fuel_city_l_100km' => 10.0, 'fuel_highway_l_100km' => 6.9,
                'image_path' => 'cars/honda-civic',
                'description_en' => 'The Honda Civic Type R is the ultimate front-wheel drive hot hatch.'
            ],
            [
                'make' => 'Ford', 'model' => 'Mustang GT', 'year' => 2024, 'trim' => 'Premium',
                'engine_type' => '5.0L V8', 'horsepower' => 480,
                'zero_to_100_kmh' => 4.2, 'top_speed_kmh' => 250,
                'transmission' => 'automatic', 'gears' => 10, 'drivetrain' => 'RWD',
                'fuel_type' => 'petrol', 'body_type' => 'coupe',
                'oil_capacity_l' => 7.6, 'oil_density_type' => '5W-30',
                'hydraulic_capacity_l' => 1.4, 'hydraulic_fluid_type' => 'Mercon LV',
                'fuel_combined_l_100km' => 12.5, 'fuel_city_l_100km' => 15.0, 'fuel_highway_l_100km' => 9.5,
                'image_path' => 'cars/ford-mustang',
                'description_en' => 'The Ford Mustang GT with its legendary 5.0L V8 delivers pure American muscle.'
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}