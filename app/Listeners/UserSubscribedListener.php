<?php

namespace App\Listeners;

use App\Events\UserSubscribedEvent;
use App\Notifications\NotifyAdmin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserSubscribed;
use App\User;

class UserSubscribedListener
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
     * @param  UserSubscribedEvent  $event
     * @return void
     */
    public function handle(UserSubscribedEvent $event)
    {
        Notification::send($event->user, new UserSubscribed($event));

        try {

            $user = $event->user;
            $user->subscription_active = 1;
            $user->save();

        } catch (\Exception $e) {
            $admins = User::where('admin', '=', 1)->get();
        Notification::send($admins, new NotifyAdmin($e));
        }
    }
}
