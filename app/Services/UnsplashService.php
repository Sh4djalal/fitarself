<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class UnsplashService
{
    protected $accessKey;
    protected $baseUrl = 'https://api.unsplash.com';

    public function __construct()
    {
        $this->accessKey = env('UNSPLASH_ACCESS_KEY');
    }

    public function searchCarImage($make, $model, $year = null)
    {
        $carKey = strtolower("{$make}_{$model}_{$year}");
        $cacheKey = 'car_image_' . md5($carKey);
        
        return Cache::remember($cacheKey, 86400, function () use ($make, $model, $year) {
            // Try Unsplash first (real photos)
            $image = $this->getFromUnsplash($make, $model, $year);
            
            // Try Imagin.studio as fallback
            if (!$image || $this->isTextOverlayImage($image)) {
                $image = $this->getFromImaginStorage($make, $model, $year);
            }
            
            // Last resort: car silhouette without text
            if (!$image) {
                $image = $this->getCarSilhouette($make, $model);
            }
            
            return $image;
        });
    }
    
    protected function isTextOverlayImage($image)
    {
        // Check if the image URL contains placeholder text patterns
        $url = $image['url'] ?? '';
        return strpos($url, 'placehold.co') !== false || 
               strpos($url, 'text=') !== false ||
               $image['photographer'] === 'Placeholder';
    }
    
    protected function getFromUnsplash($make, $model, $year)
    {
        if (!$this->accessKey) {
            return null;
        }
        
        // Build a specific search query for exterior car photos
        $searchTerms = [];
        
        if ($year) {
            $searchTerms[] = "{$year} {$make} {$model}";
        }
        $searchTerms[] = "{$make} {$model} exterior";
        $searchTerms[] = "{$make} {$model} front view";
        
        $query = implode(' ', array_slice($searchTerms, 0, 2));
        
        try {
            $response = Http::withHeaders([
                'Authorization' => "Client-ID {$this->accessKey}",
            ])->get("{$this->baseUrl}/search/photos", [
                'query' => $query,
                'per_page' => 8,
                'orientation' => 'landscape',
                'content_filter' => 'high',
            ]);
            
            if ($response->successful() && $response->json('results') && count($response->json('results')) > 0) {
                // Find the best exterior photo without text/watermarks
                $photo = $this->findBestCarPhoto($response->json('results'), $make, $model);
                
                if ($photo) {
                    return [
                        'url' => $photo['urls']['regular'],
                        'thumb' => $photo['urls']['thumb'],
                        'small' => $photo['urls']['small'],
                        'photographer' => $photo['user']['name'],
                        'photographer_url' => $photo['user']['links']['html'],
                        'description' => $photo['alt_description'] ?? "{$year} {$make} {$model}",
                    ];
                }
            }
        } catch (\Exception $e) {
            \Log::error('Unsplash API error: ' . $e->getMessage());
        }
        
        return null;
    }
    
    protected function findBestCarPhoto($results, $make, $model)
    {
        $excludeTerms = ['interior', 'dashboard', 'engine', 'wheel', 'logo', 'badge', 'detail', 'close up'];
        $priorityTerms = ['exterior', 'front', 'side', 'rear', 'full', 'parked', 'driving', 'road'];
        
        $bestPhoto = null;
        $bestScore = 0;
        
        foreach ($results as $photo) {
            $altText = strtolower($photo['alt_description'] ?? '');
            $description = strtolower($photo['description'] ?? '');
            $combined = $altText . ' ' . $description;
            
            // Skip interior/close-up photos
            $skip = false;
            foreach ($excludeTerms as $term) {
                if (strpos($combined, $term) !== false) {
                    $skip = true;
                    break;
                }
            }
            
            if ($skip) {
                continue;
            }
            
            // Score the photo
            $score = 0;
            foreach ($priorityTerms as $term) {
                if (strpos($combined, $term) !== false) {
                    $score += 10;
                }
            }
            
            // Bonus for matching make/model
            if (strpos($combined, strtolower($make)) !== false) {
                $score += 20;
            }
            if (strpos($combined, strtolower($model)) !== false) {
                $score += 20;
            }
            
            // Prefer higher quality
            if (($photo['width'] ?? 0) > 4000) {
                $score += 15;
            }
            
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestPhoto = $photo;
            }
        }
        
        return $bestPhoto ?? ($results[0] ?? null);
    }
    
    protected function getFromImaginStorage($make, $model, $year)
    {
        // Free car image API - reliable car photos
        $formattedMake = strtolower($make);
        $formattedModel = strtolower(str_replace(' ', '-', $model));
        
        // Using vehicle-specific image CDN (no text overlay)
        $imageUrl = "https://cdn.imagin.studio/getImage?customer=img&make={$formattedMake}&modelFamily={$formattedModel}&zoomType=fullscreen&angle=30";
        
        if ($year) {
            $imageUrl .= "&modelYear={$year}";
        }
        
        // Verify the image exists by making a quick HEAD request
        try {
            $response = Http::head($imageUrl);
            if ($response->successful()) {
                return [
                    'url' => $imageUrl,
                    'thumb' => $imageUrl . "&width=400",
                    'photographer' => 'Imagin Studio',
                    'description' => "{$year} {$make} {$model}",
                ];
            }
        } catch (\Exception $e) {
            // Fall through to next option
        }
        
        return null;
    }
    
    protected function getCarSilhouette($make, $model)
    {
        // Use clean car silhouette images (no text, no watermark)
        $silhouettes = [
            'sedan' => 'https://www.freeiconspng.com/uploads/car-side-view-png-16.png',
            'suv' => 'https://www.freeiconspng.com/uploads/suv-car-side-view-png-2.png',
            'truck' => 'https://www.freeiconspng.com/uploads/pickup-truck-side-view-png-0.png',
            'sports' => 'https://www.freeiconspng.com/uploads/sports-car-png-2.png',
        ];
        
        // Determine car type based on model
        $carType = 'sedan';
        if (strpos(strtolower($model), 'hilux') !== false || strpos(strtolower($model), 'truck') !== false) {
            $carType = 'truck';
        } elseif (strpos(strtolower($model), 'land cruiser') !== false || strpos(strtolower($model), 'prado') !== false) {
            $carType = 'suv';
        } elseif (strpos(strtolower($model), 'supra') !== false || strpos(strtolower($model), 'gt') !== false) {
            $carType = 'sports';
        }
        
        // Use Unsplash generic car image as fallback (no text)
        $genericCarImages = [
            'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=1200',  // Red car
            'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1200',  // White car
            'https://images.unsplash.com/photo-1552519507-88aa2dfa9fdb?w=1200',    // Sports car
            'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=1200',    // Luxury car
        ];
        
        $randomIndex = abs(crc32($make . $model)) % count($genericCarImages);
        
        return [
            'url' => $genericCarImages[$randomIndex],
            'thumb' => $genericCarImages[$randomIndex] . '&h=225',
            'photographer' => 'Unsplash',
            'description' => "{$make} {$model}",
        ];
    }
}