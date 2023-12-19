<?php
namespace App\Repositories;

use App\Models\Visitors;
use Illuminate\Support\Carbon;

class TrackingRepository extends BaseRepository
{
    public function __construct(Visitors $visitors)
    {
        parent::__construct($visitors);
    }

    public function store(array $data)
    {
        $jsonData = $data['deviceInfo']?? null;;
        $encodedData = json_encode($jsonData);

        $visitorData = [
            'utm_source' => $data['utm_source'],
            'utm_medium' => $data['utm_medium'],
            'utm_content' => $data['utm_content'],
            'utm_term' => $data['utm_term'],
            'utm_campaign' => $data['utm_campaign'],
            'referrer' => $data['referrer'],
            'dateTime' => $data['dateTime'],
            'country' => $data['country'],
            'userAgent' => $data['userAgent'],
            'deviceInfo' => $encodedData,
            'rcrmVisitorId' => $data['rcrmVisitorId'],
            'sessionId' => $data['sessionId'],
            'initial_url' => $data['initial_url'],
            'url_visited' => $data['url_visited'],
        ];

        $this->create($visitorData);
    }

    public function seeVisitors($perPage = 10)
    {
        return $this->model->paginate($perPage);
    }

    public function visitorStats($request)
    {
        $statDate = $request->rangeOne;
        $endDate = $request->rangeTwo; 
        $lastMonth = now()->startOfMonth();
        $lastToLastMonth = now()->startOfMonth()->subMonth();
        
        $allRcrmVisitorIds = $this->model
            ->where('rcrmVisitorId', '<>', null)
            ->whereBetween('created_at', [$statDate, $endDate])
            ->count();

        $allRcrmVisitorIds_lastToLastMonth = $this->model
            ->where('rcrmVisitorId', '<>', null)
            ->whereBetween('created_at', [$lastToLastMonth, $lastMonth])
            ->count();

        $allSessionIds = $this->model
            ->where('sessionId', '<>', null)
            ->where('created_at', '>=', $lastMonth)
            ->count();

        $allSessionIds_lastToLastMonth = $this->model
            ->where('sessionId', '<>', null)
            ->whereBetween('created_at', [$lastToLastMonth, $lastMonth])
            ->count();

        $uniqueRcrmVisitorIds = $this->model
            ->where('rcrmVisitorId', '<>', null)
            ->where('created_at', '>=', $lastMonth)
            ->distinct('rcrmVisitorId')
            ->count('rcrmVisitorId');

        $uniqueRcrmVisitorIds_lastToLastMonth = $this->model
            ->where('rcrmVisitorId', '<>', null)
            ->whereBetween('created_at', [$lastToLastMonth, $lastMonth])
            ->distinct('rcrmVisitorId')
            ->count('rcrmVisitorId');

        $uniqueSessionIds = $this->model
            ->where('sessionId', '<>', null)
            ->where('created_at', '>=', $lastMonth)
            ->distinct('sessionId')
            ->count('sessionId');

        $uniqueSessionIds_lastToLastMonth = $this->model
            ->where('sessionId', '<>', null)
            ->whereBetween('created_at', [$lastToLastMonth, $lastMonth])
            ->distinct('sessionId')
            ->count('sessionId');

        return [
            'all_rcrmVisitorId_count' => $allRcrmVisitorIds,
            'allRcrmVisitorIds_lastToLastMonth' => $allRcrmVisitorIds_lastToLastMonth,
            'all_sessionId_count' => $allSessionIds,
            'allSessionIds_lastToLastMonth' => $allSessionIds_lastToLastMonth,
            'unique_rcrmVisitorId_count' => $uniqueRcrmVisitorIds,
            'uniqueRcrmVisitorIds_lastToLastMonth' => $uniqueRcrmVisitorIds_lastToLastMonth,
            'unique_sessionId_count' => $uniqueSessionIds,
            'uniqueSessionIds_lastToLastMonth' => $uniqueSessionIds_lastToLastMonth
        ];
    }

    public function fetchSessionDetails($sessionId)
    {
        return $this->model->where('sessionId', $sessionId)->first();
    }

    public function fetchVisitorJourney($visitorId)
    {
        return $this->model->where('rcrmVisitorId', $visitorId)->get();
    }
}
