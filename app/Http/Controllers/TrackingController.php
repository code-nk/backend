<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TrackingRepository;

class TrackingController extends Controller
{
    protected $trackingRepository;

    public function __construct(TrackingRepository $trackingRepository)
    {
        $this->trackingRepository = $trackingRepository;
    }

    public function getTrackingScript()
    {
        return view('tracking-script');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data if needed

        $data = $request->all();

        // Save the data to the database using the repository
        $this->trackingRepository->store($data);

        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'Data saved successfully'], 201);
    }

    public function seeVisitors(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $visitors = $this->trackingRepository->seeVisitors($perPage);

        return response()->json(['data' => $visitors], 200);
    }

    public function visitorStats(Request $request)
    {
        $stats = $this->trackingRepository->visitorStats($request);

        return response()->json($stats, 200);
    }

    public function fetchSessionDetails(Request $request)
    {
        $sessionId = $request->input('sessionId');

        $visitor = $this->trackingRepository->fetchSessionDetails($sessionId);

        if (!$visitor) {
            return response()->json(['message' => 'Visitor not found'], 404);
        }

        return response()->json(['visitor' => $visitor]);
    }

    public function fetchVisitorJourney(Request $request)
    {
        $visitorId = $request->input('visitorId');

        $visitor = $this->trackingRepository->fetchVisitorJourney($visitorId);

        if (!$visitor) {
            return response()->json(['message' => 'Visitor not found'], 404);
        }

        return response()->json(['visitor' => $visitor]);
    }
}

