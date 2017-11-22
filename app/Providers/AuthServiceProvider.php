<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Job;
use App\Policies\JobPolicy;
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
        'App\Model' => 'App\Policies\ModelPolicy',
        Job::class => JobPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();
        Passport::enableImplicitGrant();

        // Dashboard Policy
        Gate::define('dashboard-view', function ($user) {
            return count($user->dashboard_permissions) > 0;
        });

         // Employee Policies
        Gate::define('employee-view', function ($user) {
            return count($user->employees_permissions) > 0;
        });

        // Employee Policies
        Gate::define('employer-view', function ($user) {
            return count($user->employers_permissions) > 0;
        });

        // Job Policies
        Gate::define('job-view', function ($user) {
            return $user->job_permissions > 0;
        });

        // Payout Policies
        Gate::define('payout-view', function ($user) {
            return count($user->payout_permissions) > 0;
        });

        // Recipient Policies
        Gate::define('recipient-view', function ($user) {
            return count($user->recipient_permissions) > 0;
        });

        // Reports Policies
        Gate::define('reports-view', function ($user) {
            return count($user->reports_permissions) > 0;
        });

        // Push Policies
        Gate::define('push-view', function ($user) {
            return count($user->push_permissions) > 0;
        });

        // Settings Policies
        Gate::define('settings-view', function ($user) {
            return count($user->settings_permissions) > 0;
        });

        // Administrator
        Gate::define('admin-view', function ($user) {
            return $user->role == 'Administrator';
        });

//        Passport::tokensExpireIn(Carbon::now()->addDays(15));
//
//        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        //
    }
}
