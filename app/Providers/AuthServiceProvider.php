<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return url(env('FRONTEND_URL')) . "/resetpassword/{$token}?email={$token}";
        });
        //

        Gate::define('access-vendor-menu', function (User $user) {
            return $user->role == 'vendor';
        });
    }
}
