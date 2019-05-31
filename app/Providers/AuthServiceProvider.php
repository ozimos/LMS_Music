<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-model', function ($user, $model) {
            return $user->id == $model->user_id;
        });
        Gate::define('delete-model', function ($user, $model) {
            return $user->id == $model->user_id || $user->isAdmin;
        });
        Gate::define('pass', function ($user, $model) {
            return true;
        });
    }
}
