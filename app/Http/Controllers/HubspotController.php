<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HubspotRepository;

class HubspotController extends Controller
{
    private $hubspotRepository;

    public function __construct(HubspotRepository $hubspotRepository)
    {
        $this->hubspotRepository = $hubspotRepository;
    }

    public function hubspotWebhook(Request $request)
    {
        // Retrieve the payload data from the request
        $payload = $request->all();

        // Verify the payload and process it
        if ($payload && isset($payload[0]['subscriptionType']) && $payload[0]['subscriptionType'] === 'contact.creation') {
            // Fetch the contact details using the objectId from the payload
            $contactId = $payload['objectId'];

            // Use the HubspotRepository to fetch contact details
            $hubspotContact = $this->hubspotRepository->fetchContactDetails($contactId);

            // Process the contact details (e.g., store in your database, send notifications, etc.)
            // You can access the contact details in $hubspotContact
            // ...

            // Respond with a 200 OK status to acknowledge the webhook
            return response()->json(['message' => 'Webhook processed successfully']);
        }

        // If the payload is not valid or not the expected type, respond with an error
        return response()->json(['error' => 'Invalid webhook payload'], 400);
    }
}
