<?php

namespace App\Http\Controllers;

use App\ApplicationSetting;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


     protected $app_settings;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->app_settings = ApplicationSetting::findOrFail(1);
       // View::share('app_settings', $this->app_settings);
    }

}
