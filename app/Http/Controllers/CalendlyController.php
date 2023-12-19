<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CalendlyRepository;

class CalendlyController extends Controller
{
    protected $calendlyRepository;

    public function __construct(CalendlyRepository $calendlyRepository)
    {
        $this->calendlyRepository = $calendlyRepository;
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->input('payload', []);
        $calendlyRecord = $this->calendlyRepository->create($payload);

        return response()->json(['message' => 'Record created successfully']);
    }

    public function showCalendlyRecords()
    {
        // Retrieve records from the CalendlyRepository and paginate the results
        $records = $this->calendlyRepository->getActiveRecords();

        // Return the paginated records in JSON format
        return response()->json(['data' => $records]);
    }

    public function monthlyCalendlyStats()
    {
        // Get monthly stats using the CalendlyRepository
        $stats = $this->calendlyRepository->getMonthlyStats();

        // Return the stats in JSON format
        return response()->json($stats);
    }

    public function dailyCalendlyStats()
    {
        // Get daily stats using the CalendlyRepository
        $stats = $this->calendlyRepository->getDailyStats();

        // Return the stats in JSON format
        return response()->json($stats);
    }

    public function getCalendlyStatsByDateRange($startDate, $endDate)
    {
        // Get stats within the date range using the CalendlyRepository
        $stats = $this->calendlyRepository->getByDateRange($startDate, $endDate);

        // Return the stats in JSON format
        return response()->json($stats);
    }
}
