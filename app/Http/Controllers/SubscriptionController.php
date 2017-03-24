<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Events\UserSubscribedEvent;
use App\Events\UserChangedPlansEvent;
use App\Events\UserChangedCreditCardEvent;
use App\Events\UserResubscribedEvent;
use App\Events\UserUnsubscribedEvent;


class SubscriptionController extends Controller
{
    /**
     * Show Plan with form to subscribe
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        // get the plan by id from cache
        $plan = $this->getPlanByIdOrFail($id);

        return view('plan', compact('plan'));
    }

    /**
     * Handles swapping the user's plan for a different one
     *
     * @return void
     */
    public function postSwapPlan()
    {
        $newPlan = Input::get('plan_to_swap_to');
        if ($newPlan) {
            $user = Auth::user();
            if ($user->subscription('main')->swap($newPlan)) {

                event(new UserChangedPlansEvent($user, $newPlan));

                return redirect()->back()->with('notice', 'Your subscription has been changed as requested!');
            } else {

                return redirect()->back()->with('notice', 'Plan swap failed. Please try again later or contact technical support.');
            }
        } else {
            return redirect()->back();
        }
    }

    public function postUpdateCreditCard()
    {
        $user = Auth::user();
        $token = Input::get('token');
        try {
            $user->updateCard($token);

                }  catch (\Exception $e) {
            // Catch any error from Stripe API request and show
            return redirect()->back()->with('notice', $e->getMessage());
        }
            event(new UserChangedCreditCardEvent($user));
            return redirect()->back()->with('notice', 'Your credit card information has been updated!');

    }

    /**
     * Handle subscription request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribe(Request $request)
    {
        // Validate request
        $this->validate( $request, [ 'stripeToken' => 'required', 'plan' => 'required'] );

        // User chosen plan
        $pickedPlan = $request->get('plan');

        // Current logged in user
        $me = Auth::user();

        try {
            // check already subscribed and if already subscribed with picked plan
            if( $me->subscribed('main') && ! $me->subscribedToPlan($pickedPlan, 'main') ) {

                // swap if different plan attempt
                $me->subscription('main')->swap($pickedPlan);

            } else {
                // Its new subscription

                // if user has a coupon, create new subscription with coupon applied
                if( $coupon = $request->get('coupon') ) {

                    $me->newSubscription( 'main', $pickedPlan)
                        ->withCoupon($coupon)
                        ->create($request->get('stripeToken'), [
                            'email' => $me->email
                        ]);

                } else {

                    // Create subscription
                    $me->newSubscription( 'main', $pickedPlan)->create($request->get('stripeToken'), [
                        'email' => $me->email,
                        'description' => $me->name
                    ]);
                }

            }
        } catch (\Exception $e) {
            // Catch any error from Stripe API request and show
            return redirect()->back()->withErrors(['notice' => $e->getMessage()]);
        }
        event(new UserSubscribedEvent($me, $pickedPlan));
        return redirect()->route('home')->with('notice', 'You are now subscribed to ' . $pickedPlan . ' plan.');
    }

    /**
     * Show subscription cancellation confirmation screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function confirmCancellation()
    {
        return view('confirmation');
    }

    /**
     * Handle subscription cancellation request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelSubscription(Request $request)
    {
        $user = $request->user();
        try {
            $user->subscription('main')->cancel();
        } catch ( \Exception $e) {
            return redirect()->route('home')->with('notice', $e->getMessage());
        }

        event(new UserUnsubscribedEvent($user));
        return redirect()->route('home')->with('notice',
            'Your Subscription has been canceled.'
        );
    }

    /**
     * Handle Resume subscription
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resumeSubscription(Request $request)
    {
            try {
                $request->user()->subscription('main')->resume();
            } catch (\Exception $e) {
                return redirect()->route('home')->with('notice', $e->getMessage());
            }
            $user = auth()->user();

            event(new UserResubscribedEvent($user));

            return redirect()->route('home')->with('notice',
                'Glad to see you back. Your Subscription has been resumed.'
            );
    }

    /**
     * Get Cached Plan by Id
     * @param $id
     * @return mixed
     */
    private function getPlanByIdOrFail($id)
    {
        $plans = Plan::getStripePlans();

        if( ! $plans ) throw new NotFoundHttpException;

        return array_first(array_filter( $plans, function($plan) use ($id) {
            return $id == $plan->id;
        }));
    }
}
