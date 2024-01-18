<?php

namespace App\Listeners;

use App\Events\PersonEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;

class PersonEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PersonEvent $event): void
    {
        Storage::append('person_access_log.txt',
            '[PersonEvent] ' .now() . ' ' . $event->getTask()->all_data
        );
    }
}
