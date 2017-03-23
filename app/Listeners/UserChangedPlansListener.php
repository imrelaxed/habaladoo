<?php

namespace App\Listeners;

use App\Events\UserChangedPlansEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\UserChangedPlans;
use Illuminate\Support\Facades\Notification;

class UserChangedPlansListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserChangedPlansEvent  $event
     * @return void
     */
    public function handle(UserChangedPlansEvent $event)
    {
        Notification::send($event->user, new UserChangedPlans($event));
    }
}
