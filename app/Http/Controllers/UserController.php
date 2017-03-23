<?php namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Notifications\NotifyAdmin;
use Illuminate\Support\Facades\Notification;


class UserController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }


    public function getBilling()
    {

        $lastfour = auth()->user()->card_last_four;

        $settings = $this->app_settings;
        $plans = Plan::getStripePlans();
        // Check is subscribed
        $is_subscribed = Auth::user()->subscribed('main');

        // If subscribed get the subscription
        $subscription = Auth::user()->subscription('main');

        $title = 'Dashboard';
        return view('settings', compact('plans', 'settings', 'is_subscribed', 'subscription', 'lastfour'));
    }

    public function getSettings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }

    public function postUpdateSettings(Request $request)
    {
        $user = Auth::user();

        $this->validate( $request, [
            'name' => [
                'required',
                'max:128',
            ],
            'email' => [
                'required',
                'max:128',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->email = $request->get('email');
        $user->name =  $request->get('name');

        if($user->save())
        {
            return back()->with('notice', 'Settings updated successfully.');
        }
        else
        {
            return back()->with('notice', 'Unable to update settings.');
        }
    }

    public function getChangePassword()
    {
        $user = Auth::user();
        return view('user.password', compact('user'));
    }

    public function postChangePassword(Request $request)
    {

        $messages = [
            'regex' => 'The :attribute must be at least 6 characaters long, contain a number, an upper case letter and a lower case letter.',
        ];

        $this->validate( $request, [
            'current_password' => 'required',
            'password' => 'required|min:6|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$/|confirmed',
        ], $messages);

        $user = Auth::user();
        $current_password = $user->getAuthPassword();

        if(Hash::check($request['current_password'], $current_password))
        {

            $user->password = Hash::make($request['password']);;
            if($user->save())
            {
                return back()->with('notice', 'Password updated successfully.');
            }
            else
            {
                return back()->with('notice', 'Unable to update password.');
            }

        }
        else
        {
            return back()->with('notice', 'Please enter the correct current password.');
        }


    }
 /*
    public function testNotify() {

        $admins = User::where('admin', '=', 1)->get();
        try {
            Notification::send($admins, new NotifyAdmin($admins));

        } catch (\Exception $e) {
            echo $e;
        }
    }
    */
}