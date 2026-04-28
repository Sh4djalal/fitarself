<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        Ad::create([
            'title_en' => 'Premium Engine Oil Sale',
            'title_ku' => 'فرۆشتنی ڕۆنی مەکینەی پریمیەم',
            'image_path' => 'ads/ad1.jpg',
            'link_url' => '#',
            'is_active' => true,
            'sort_order' => 1,
            'sponsor_name' => 'OilMaster Iraq',
        ]);

        Ad::create([
            'title_en' => 'Diagnostic Tools - 20% Off',
            'title_ku' => 'ئامێری دۆزینەوەی کێشە - ٢٠٪ داشکاندن',
            'image_path' => 'ads/ad2.jpg',
            'link_url' => '#',
            'is_active' => true,
            'sort_order' => 2,
            'sponsor_name' => 'TechAuto Erbil',
        ]);

        Ad::create([
            'title_en' => 'Book Your Service Today',
            'title_ku' => 'ئەمڕۆ ڕیسێرڤی خزمەتگوزاری بکە',
            'image_path' => 'ads/ad3.jpg',
            'link_url' => '#',
            'is_active' => true,
            'sort_order' => 3,
            'sponsor_name' => 'QuickFix Garage',
        ]);
    }
}