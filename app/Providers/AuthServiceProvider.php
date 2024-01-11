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
        'App\Models\Product' => 'App\Policies\ProductPolicy',
        'App\Models\Role' => 'App\Policies\RolePolicy',
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

        Gate::before(function($user, $ability) {
            if($user->super_admin) {
             return true;
            }
        });

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
