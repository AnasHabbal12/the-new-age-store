<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    public function register()
    {
        parent::register();
        $this->app->bind('abilities', function () {
            return include base_path('data/abilities.php');
        });

    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        $abilities = $this->app->make('abilities');

        foreach($abilities as $code => $lable) {
            Gate::define($code, function($user) use ($code) {
                return $user->hasAbility($code);
            });
        }
        // Gate::define('categories.create', function($user) {
        //     return false;
        // });
        // Gate::define('categories.update', function($user) {
        //     return false;
        // });
        // Gate::define('categories.delete', function($user) {
        //     return false;
        // });
    }
}
