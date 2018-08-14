<?php
declare( strict_types = 1 );

namespace App\Providers;

use App\Services\Config\ConfigService;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    	if (! isLocalEnvironment() && ! app()->runningInConsole())
	        $this->app->make(ConfigService::class)->applySiteConfigs(\Request::getHttpHost());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
