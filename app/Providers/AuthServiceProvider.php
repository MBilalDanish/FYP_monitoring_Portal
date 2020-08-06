<?php

namespace App\Providers;

use Laravel\Passport\Passport;
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
        
        Gate::define('isAdmin', function ($user) {
            return $user->type === 'admin';
        });
        Gate::define('isStudent', function ($user) {
            return $user->type === 'student';
        });
        Gate::define('isExternal', function ($user) {
            return $user->type === 'external';
        });
        Gate::define('isSupervisor', function ($user) {
            return $user->type === 'supervisor';
        });
        Gate::define('isTeacher', function ($user) {
            if($user->type === 'admin' || $user->type === 'supervisor' || $user->type === 'external')
            {
                return true;
            } 
            else{
                return false;
            }
        });
        Gate::define('isAdminOrExternal', function ($user) {
            if($user->type === 'admin' ||  $user->type === 'external')
            {
                return true;
            } 
            else{
                return false;
            }
        });
  
        Passport::routes();
        //
    }
}
