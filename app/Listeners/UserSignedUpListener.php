<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Notifications\UserSignedUp;
use Illuminate\Support\Facades\Notification;

class UserSignedUpListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param Registered $event
     */
    public function handle(Registered $event)
    {
        Notification::send($event->user, new UserSignedUp($event));
    }
}
