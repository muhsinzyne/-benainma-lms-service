<?php
namespace MuhsinZyne\LmsService;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use MuhsinZyne\LmsService\Middleware\LmsService;

class BenainmaLmsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $kernel = $this->app->make(Kernel::class);
        $kernel->pushMiddleware(LmsService::class);

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'lms');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lms');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
