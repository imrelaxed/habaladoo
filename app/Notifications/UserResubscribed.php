<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class UserResubscribed extends Notification
{
    use Queueable;

    protected $data;
    protected $subscription;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->data = $event;
        $timestamp = $event->user->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
        $this->subscription = Carbon::createFromTimeStamp($timestamp)->toFormattedDateString();

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(config('app.name').' Subscription Reactivated')
            ->greeting('Hi '.ucfirst($this->data->user->name).'!')
            ->success()
            ->line('Thank you for reactivating your '. config('app.name') .' subscription.')
            ->line('Your next billing date is '.$this->subscription.'. You can login to your dashboard using the button below.')
            ->action('Dashboard', route('home'))
            ->line('Thank you for using '.config('app.name').'!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
