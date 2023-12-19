<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class OpenAIController extends Controller
{
    public function getChatGPTResponse(Request $request)
{
    try {
        $prompt = $request->input('prompt');

        $client = new Client();

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . Config::get('app.openai_api_key'),
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo', // Use a chat model suitable for conversation
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "I am training you on my Database. The name of my Database is ujt. It has  various tables. Let me tell you about each on of them. There is a table called calendly_records and it has following fields - 'cancel_url', 'email', 'name', 'reschedule_url', 'rescheduled', 'status', 'text_reminder_number', 'timezone', 'start_time', 'membership_user', 'membership_email', 'guest_email', 'end_time', 'uri', 'event_id', 'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'event_id'. The utm_term field contains 'rcrmVisitorId' from visitors table.  This table usually contains demo information. So if somebody has any query related to demos, this is the table that will help us. Similarly I have a visitors table which has the following fields-  'utm_source', 'utm_medium', 'utm_content', 'utm_term', 'utm_campaign', 'referrer', 'dateTime', 'country', 'userAgent', 'deviceInfo', 'rcrmVisitorId', 'sessionId'. So if somebody is looking for information on visitors / users. We can use this table.
                                    Now based on my next prompt, generate a sql query for me to search data. My next prompt might not contain the name of the fields / column accurately but you can use your intelligence to map it to respective fields like if I prompt event column, you can work on event_column automatically. Use LIKE statement to search for keywords rather than directly finding it. Also i may not accurately tell the field name in my response so kindly try to relate it fields that I have already shared. Please remember, only return SQL query and nothing else
                                    ",
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        $result = $this->runDBQuery($data['choices'][0]['message']['content'], $prompt);

        return response()->json(['response' => $result, 'query' => $data['choices'][0]['message']['content'], 'message' => "Successful"]);
    } catch (\Exception $e) {
        // Handle the exception, log it, or return an error response
        return response()->json(['message' => "Failed"], 200);
    }
}


    public function runDBQuery($query, $prompt) {
        $results = DB::select($query);

        foreach ($results as $result) {
            $resultString = json_encode((array)$result);
        }
        $client = new Client();

        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . Config::get('app.openai_api_key'),
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo', // Use a chat model suitable for conversation
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => "This is the result of the prompt - {$resultString}. Don't give reference of the prompt in reply.",
                    ],
                ],
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        

        return response()->json(['response' => $results, 'data' => $data]);
    }
}
