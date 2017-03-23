<?php namespace App\Http\Controllers;

use App\ApplicationSetting;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Auth;
use Artisan;
use App\Plan;

class AdminController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Admin Controller
    |--------------------------------------------------------------------------
    |
    | Every modern web application has some sort of administrative dashboard
    | that enables the people behind the application to modify content and
    | get a general overview. Is also nice for non-technical founders.
    |
    */
    protected $plan;

    public function __construct()
    {
        $this->middleware('admin');
        $this->plan = Plan::getStripePlans();
        parent::__construct();

    }
    // load first column of app settings table and pass it to the admin view.
    public function getIndex()
    {
        $title = 'Settings';
        $user = Auth::user();
        $settings = $this->app_settings;

        return view('admin.index', compact('title', 'settings', 'user'));

    }

    public function getUsers()
    {
        $title = 'Users';
        $users = User::where('admin', '=', 0)->paginate(15);
        $total_users = User::where('admin', '=', 0)->count();
        $total_active_subscribers = User::where('subscription_active', '=', 1)->where('admin', '=', 0)->count();
        $total_non_subscribers = $total_users - $total_active_subscribers;
        return view('admin.users', compact('title', 'users', 'total_users', 'total_active_subscribers', 'total_non_subscribers'));
    }

    public function getDeveloperZone()
    {
        $title = 'Developer Zone';
        $logs = file(storage_path() . '\logs\laravel.log');
        return view('admin.developer-zone', compact('title', 'logs'));
    }

    public function getAnalytics()
    {
        $title = 'Analytics';
        $settings = $this->app_settings;
        $total_customers = User::where('subscription_active', '=', 1)->where('admin', '=', 0)->count();
        return view('admin.analytics', compact('title', 'settings', 'total_customers'));
    }


    public function getEngineRoom()
    {
        $title = 'Engine Room';
        $settings = $this->app_settings;
        return view('admin.engine-room', compact('title', 'settings'));
    }


    /**
     * @return \Illuminate\View\View
     */
    public function getPlans()
    {
        $title = 'Plans';
        $cachedPlans = Plan::getStripePlans();
        $plans = Plan::all();
        return view('admin.plans', compact('title', 'plans', 'cachedPlans'));
    }

    public function getFlushCachedPlan () {
        Cache::forget('stripe.plans');
        return redirect()->back();
    }


    public function postUpdateSettings()
    {

        $setting = ApplicationSetting::find(1);

        $exceptions = [
            '_token',
            'apple_touch_icon_152x152',
            'apple_touch_startup_image_640x920',
            'apple_touch_startup_image_640x1096',
            'apple_touch_startup_image_750x1334',
            'apple_touch_startup_image_1242x2208',
            'apple_touch_startup_image_1536x2008',
            'application_shortcut_icon_196x196',
            'application_favicon_ico_32x32',
            'application_favicon_png_32x32',
            'company_logo'
        ];

        $input = Request::except($exceptions);

        foreach($input as $key => $value)
        {
            $setting[$key] = $value;
        }

        $setting->save();


        /**
         * Handle uploading meta images such as shortcut icons,
         * Apple touch images and other assets.
         *
         * @param array $images
         * @param       $destinationPath
         */
        function saveUploadedImages($images = [], $destinationPath)
        {
            foreach ($images as $key => $value) {
                if( Request::hasFile($key) ) {
                    $image = Request::file($key);
                    $image->move($destinationPath . "/", $value);
                }
            }
        }

        $icons_touch_images_path = base_path() . '/public/img';

        $icons_touch_images = [
            'application_shortcut_icon_196x196'   => 'shortcut-icon-196x196.png',
            'application_favicon_ico_32x32'       => 'shortcut-icon.ico',
            'application_favicon_png_32x32'       => 'shortcut-icon.png',

            'apple_touch_icon_152x152'            => 'apple-touch-icon.png',
            'apple_touch_startup_image_640x920'   => 'apple-touch-startup-image-640x920.png',
            'apple_touch_startup_image_640x1096'  => 'apple-touch-startup-image-640x1096.png',
            'apple_touch_startup_image_750x1334'  => 'apple-touch-startup-image-750x1334.png',
            'apple_touch_startup_image_1242x2208' => 'apple-touch-startup-image-1242x2208.png',
            'apple_touch_startup_image_1536x2008' => 'apple-touch-startup-image-1536x2008.png',

            'company_logo'                        => 'company_logo.svg'
        ];

        saveUploadedImages($icons_touch_images, $icons_touch_images_path);

        return redirect()->back();

    }

    /**
     * Handles clearing the laravel.log file.
     *
     * @return  void
     */
    public function getClearLogs()
    {
        Artisan::call('clear:logs');
        return redirect()->back();
    }
    /**
     * Handles importing Stripe plans into cache.
     *
     * @param \App\Http\Controllers\PlanController $plan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getImportSubscriptionPlans(PlanController $plan)
    {
        $plan->importPlansToCache();
        return redirect()->back();
    }


    /**
     * Handles updating a cached plan.
     *
     * @param \App\Http\Controllers\PlanController $plan
     * @param null                                 $plan_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpdateCachedPlan(PlanController $plan, $plan_id = null)
    {
        $plan->updateCachedPlan($plan_id);
        return redirect()->back();
    }

    /**
     * Handles deleting a cached plan.
     *
     * @param \App\Http\Controllers\PlanController $plan
     * @param null                                 $plan_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteCachedPlan(PlanController $plan, $plan_id = null)
    {
        $plan->deleteCachedPlan($plan_id);
        return redirect()->back();
    }

    /**
     * Handles deleting a plan on Stripe.
     *
     * @param \App\Http\Controllers\PlanController $plan
     * @param null                                 $plan_stripe_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDeleteStripePlan(PlanController $plan, $plan_stripe_id = null)
    {
        $plan->deletePlanFromStripe($plan_stripe_id);
        return redirect()->back();
    }

}
