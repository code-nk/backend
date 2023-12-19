<?php

namespace App\Repositories;

use App\Models\SignupRecord;

class SignupRecordRepository extends BaseRepository
{
    public function __construct(SignupRecord $signupRecord)
    {
        parent::__construct($signupRecord);
    }

    public function store(array $data)
    {
        // Create a new SignupRecord instance
        $signupRecord = new SignupRecord;

        // Fill the model with data from the array, even if it's null
        $signupRecord->fill([
            'rcrmVisitorId' => $data['rcrmVisitorId'],
            'sessionId' => $data['sessionId'],
            'referrer' => $data['referrer'],
            'name' => $data['name'],
            'email' => $data['email'],
            'utm_source' => $data['utm_source'],
            'utm_medium' => $data['utm_medium'],
            'utm_content' => $data['utm_content'],
            'utm_term' => $data['utm_term'],
            'utm_campaign' => $data['utm_campaign'],
        ]);

        // Save the record to the database
        $signupRecord->save();

        // Return the created SignupRecord instance
        return $signupRecord;
    }

    
}
