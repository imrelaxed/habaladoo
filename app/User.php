<?php

namespace App;

use Event;
use App\Events\UserSignedUpEvent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use App\Notifications\ResetPassword;
use Stripe\Subscription;

class User extends Authenticatable
{
    use Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        if( $this->admin == 1 )
        {
            return true;
        }

        return false;
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
/* fire event on creation, decided to go with laravel built in registered event instead.
    public static function boot()
    {
                static::created(function($model){
            event(new UserSignedUpEvent($model));
        });
    }
*/
}
