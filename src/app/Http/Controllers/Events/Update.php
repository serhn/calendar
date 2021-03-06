<?php

namespace LaravelEnso\Calendar\App\Http\Controllers\Events;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use LaravelEnso\Calendar\App\Enums\UpdateType;
use LaravelEnso\Calendar\App\Http\Requests\ValidateEventRequest;
use LaravelEnso\Calendar\App\Http\Resources\Event as Resource;
use LaravelEnso\Calendar\App\Models\Event;

class Update extends Controller
{
    use AuthorizesRequests;

    public function __invoke(ValidateEventRequest $request, Event $event)
    {
        $this->authorize('handle', $event);

        $event->updateEvent(
            $request->validated(),
            (int) $request->get('updateType', UpdateType::OnlyThisEvent)
        )->updateReminders($request->reminders())
        ->syncAttendees($request->get('attendees'));

        return [
            'message' => __('The event was updated!'),
            'event' => new Resource($event),
        ];
    }
}
