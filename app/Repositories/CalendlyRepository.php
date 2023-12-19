<?php
// app/Repositories/CalendlyRepository.php

namespace App\Repositories;

use App\Models\Calendly;

class CalendlyRepository extends BaseRepository
{
    public function __construct(Calendly $calendly)
    {
        parent::__construct($calendly);
    }


    public function create(array $data)
    {
        $calendlyRecord = new Calendly();
        $calendlyRecord->created_at = $this->getDateTimeOrNull($data['created_at']);
        $calendlyRecord->cancel_url = $data['cancel_url'] ?? null;
        $calendlyRecord->email = $data['email'] ?? null;
        $calendlyRecord->name = $data['name'] ?? null;
        $calendlyRecord->reschedule_url = $data['reschedule_url'] ?? null;
        $calendlyRecord->rescheduled = $data['rescheduled'] ?? null;
        $calendlyRecord->status = $data['status'] ?? null;
        $calendlyRecord->text_reminder_number = $data['text_reminder_number'] ?? null;
        $calendlyRecord->timezone = $data['timezone'] ?? null;

        // Access scheduled_event properties
        $scheduledEvent = $data['scheduled_event'] ?? [];
        $calendlyRecord->start_time = $this->getDateTimeOrNull($scheduledEvent['start_time']);
        $calendlyRecord->end_time = $this->getDateTimeOrNull($scheduledEvent['end_time']);
        $calendlyRecord->uri = $data['uri'] ?? null;

        // Access event_memberships properties
        $eventMembership = $scheduledEvent['event_memberships'][0] ?? [];
        $calendlyRecord->membership_user = $eventMembership['user'] ?? null;
        $calendlyRecord->membership_email = $eventMembership['user_email'] ?? null;

        // Access event_guests properties
        $eventGuest = $scheduledEvent['event_guests'][0] ?? [];
        $calendlyRecord->guest_email = $eventGuest['email'] ?? null;

        // Access tracking properties
        $tracking = $data['tracking'] ?? [];
        $calendlyRecord->utm_campaign = $tracking['utm_campaign'] ?? null;
        $calendlyRecord->utm_source = $tracking['utm_source'] ?? null;
        $calendlyRecord->utm_medium = $tracking['utm_medium'] ?? null;
        $calendlyRecord->utm_content = $tracking['utm_content'] ?? null;
        $calendlyRecord->utm_term = $tracking['utm_term'] ?? null;

        // Event ID (if applicable)
        $calendlyRecord->event_id = 0;

        // Save the record to the database
        $calendlyRecord->save();

        return $calendlyRecord;
    }

    protected function getDateTimeOrNull($dateTime)
    {
        return $dateTime ? now()->parse($dateTime) : null;
    }

    public function getActiveRecords()
    {
        // Retrieve active records from the Calendly model
      //  return $this->model->where('status', 'active')->paginate(10);
        return $this->model
        ->where('status', 'active')
        ->where('event_name', 'like', '%demo%')
        ->paginate(10);


    }

    public function getMonthlyStats()
    {
        // Get the unique utm_source values and their counts
        return $this->model->select('utm_source')
            ->distinct()
            ->get()
            ->pluck('utm_source')
            ->mapWithKeys(function ($utmSource) {
                return [$utmSource => $this->model->where('utm_source', $utmSource)->count()];
            });
    }

    public function getDailyStats()
    {
        // Get the unique utm_source values and their counts for the day
        return $this->model->select('utm_source')
            ->distinct()
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->get()
            ->pluck('utm_source')
            ->mapWithKeys(function ($utmSource) {
                return [$utmSource => $this->model->where('utm_source', $utmSource)
                    ->whereDate('created_at', now()->format('Y-m-d'))
                    ->count()];
            });
    }

    public function getByDateRange($startDate, $endDate)
    {
        // Convert the provided date parameters to match the database format
        $startDate = date('Y-m-d 00:00:00', strtotime($startDate));
        $endDate = date('Y-m-d 23:59:59', strtotime($endDate));

        // Get the unique utm_source values and their counts within the date range
        return $this->model->select('utm_source')
            ->distinct()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->pluck('utm_source')
            ->mapWithKeys(function ($utmSource) use ($startDate, $endDate) {
                return [$utmSource => $this->model->where('utm_source', $utmSource)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->count()];
            });
    }
}
