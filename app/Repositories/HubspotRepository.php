<?php
// app/Repositories/HubspotRepository.php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HubspotRepository
{
    public function fetchContactDetails($contactId)
    {
        // Replace 'YOUR_API_KEY' with your HubSpot API key
        $apiKey = env('HUBSPOT_API_KEY');

        // HubSpot API endpoint for fetching contact details
        $url = "https://api.hubapi.com/crm/v3/objects/contacts/{$contactId}";

        // Make an HTTP GET request to fetch contact details using Guzzle HTTP
        try {
            $response = Http::withHeaders(['Authorization' => "Bearer $apiKey"])
                ->get($url);

            if ($response->successful()) {
                // Contact details are in JSON format in the response body
                Log::info("Response printing");
                Log::info($response->json());
                return $response->json();
            } else {
                // Handle API error response
                Log::error('Error fetching HubSpot contact details: ' . $response->status());
                return null; // You can handle this based on your application's requirements
            }
        } catch (\Exception $e) {
            // Handle exception (e.g., network error)
            Log::error('Exception while fetching HubSpot contact details: ' . $e->getMessage());
            return null; // You can handle this based on your application's requirements
        }
    }
}
