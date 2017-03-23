<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\UserSignedUpListener',
        ],

        'App\Events\UserSubscribedEvent' => [
            'App\Listeners\UserSubscribedListener',
        ],

        'App\Events\UserResubscribedEvent' => [
            'App\Listeners\UserResubscribedListener',
        ],

        'App\Events\UserUnsubscribedEvent' => [
            'App\Listeners\UserUnsubscribedListener',
        ],

        'App\Events\UserChangedPlansEvent' => [
            'App\Listeners\UserChangedPlansListener',
        ],

        'App\Events\UserChangedCreditCardEvent' => [
            'App\Listeners\UserChangedCreditCardListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
