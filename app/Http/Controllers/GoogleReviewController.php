<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoogleReviewController extends Controller
{
    /**
     * Fetch Google Reviews and return as JSON (for AJAX calls)
     */
    public function getReviews()
    {
        $reviews = $this->fetchGoogleReviews();

        return response()->json($reviews);
    }

    /**
     * Show the homepage with Google Reviews
     */
    public function index()
    {
        $reviewData = $this->fetchGoogleReviews();

        return view('home', compact('reviewData'));
    }

    /**
     * Fetch reviews from Google Places API with 6-hour cache
     */
    private function fetchGoogleReviews(): array
    {
        return Cache::remember('google_reviews', now()->addHours(6), function () {
            try {
                $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json', [
                    'place_id' => config('services.google.place_id'),
                    'fields'   => 'name,rating,user_ratings_total,reviews,url',
                    'key'      => config('services.google.places_api_key'),
                    'reviews_sort' => 'newest',
                ]);

                if ($response->successful()) {
                    $result = $response->json('result');

                    return [
                        'business_name'      => $result['name'] ?? '',
                        'overall_rating'     => $result['rating'] ?? 0,
                        'total_reviews'      => $result['user_ratings_total'] ?? 0,
                        'google_url'         => $result['url'] ?? '#',
                        'reviews'            => $result['reviews'] ?? [],
                    ];
                }

                Log::error('Google Places API error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                return $this->fallbackData();

            } catch (\Exception $e) {
                Log::error('Google Reviews fetch failed: ' . $e->getMessage());
                return $this->fallbackData();
            }
        });
    }

    /**
     * Fallback data when API fails
     */
    private function fallbackData(): array
    {
        return [
            'business_name'  => 'Our Business',
            'overall_rating' => 0,
            'total_reviews'  => 0,
            'google_url'     => '#',
            'reviews'        => [],
        ];
    }
}
