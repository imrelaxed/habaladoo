<?php

namespace App\Listeners;

use App\Events\UserChangedCreditCardEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;


class UserChangedCreditCardListener
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
     * @param  UserChangedCreditCardEvent  $event
     * @return void
     */
    public function handle(UserChangedCreditCardEvent $event)
    {
        //
    }
}
