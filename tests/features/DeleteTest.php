<?php

namespace LaravelEnso\Calendar\tests\features;

use LaravelEnso\Calendar\App\Enums\Frequencies;
use LaravelEnso\Calendar\App\Enums\UpdateType;
use LaravelEnso\Calendar\App\Models\Event;

class DeleteTest extends BaseTest
{
    /** @test */
    public function can_delete_all_events()
    {
        $this->create()->deleteEvent(3, UpdateType::All);

        $this->assertEmpty(Event::all());
    }

    /** @test */
    public function can_delete_single_event()
    {
        $this->create()->deleteEvent(3, UpdateType::OnlyThisEvent);

        $this->assertParents([null, 1, null, 4]);
        $this->assertDate(now()->addDay(), Event::first()->recurrence_ends_at);
    }

    /** @test */
    public function can_delete_non_frequent_event()
    {
        $this->event->frequency = Frequencies::Once;

        $this->create()->deleteEvent(1, UpdateType::OnlyThisEvent);

        $this->assertEmpty(Event::all());
    }

    /** @test */
    public function can_delete_parent_event()
    {
        $this->create()->deleteEvent(1, UpdateType::OnlyThisEvent);

        $this->assertParents([null, 2, 2, 2]);
    }

    /** @test */
    public function can_delete_following_events()
    {
        $this->count = 5;

        $this->create()->deleteEvent(3, UpdateType::ThisAndFutureEvents);

        $this->assertParents([null, 1]);
        $this->assertDate(now()->addDay(), Event::first()->recurrence_ends_at);
    }
}
