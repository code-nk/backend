<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SignupRecordRepository;

class SignupRecordController extends Controller
{
    protected $signupRecordRepository;

    public function __construct(SignupRecordRepository $signupRecordRepository)
    {
        $this->signupRecordRepository = $signupRecordRepository;
    }

    public function store(Request $request)
    {
        // Validate the incoming request if needed

        // Store the SignupRecord using the repository
        $signupRecord = $this->signupRecordRepository->store($request->all());

        // You can return a response, redirect, or perform any other action as needed
        return response()->json(['message' => 'Signup record created successfully']);
    }
}
