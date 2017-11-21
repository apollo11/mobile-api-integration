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
            return $user->dashboard_permissions[0] || $user->role_id == 0 || $user->role_id == 1;
        });

         // Employee Policies
        Gate::define('employee-add', function ($user) {
            return $user->employees_permissions[0] || $user->role_id == 0;
        });
        Gate::define('employee-edit', function ($user) {
            return $user->employees_permissions[1] || $user->role_id == 0;
        });
        Gate::define('employee-delete', function ($user) {
            return $user->employees_permissions[2] || $user->role_id == 0;
        });
        Gate::define('employee-view', function ($user) {
            return $user->employees_permissions[3] || $user->role_id == 0 || $user->role_id == 1;
        });

        // Employee Policies
        Gate::define('employer-add', function ($user) {
            return $user->employers_permissions[0] || $user->role_id == 0;
        });
        Gate::define('employer-edit', function ($user) {
            return $user->employers_permissions[1] || $user->role_id == 0;
        });
        Gate::define('employer-delete', function ($user) {
            return $user->employers_permissions[2] || $user->role_id == 0;
        });
        Gate::define('employer-view', function ($user) {
            return $user->employers_permissions[3] || $user->role_id == 0 || $user->role_id == 1;
        });

        // Job Policies
        Gate::define('job-add', function ($user) {
            return $user->job_permissions[0] || $user->role_id == 0 || $user->role_id == 1;
        });
        Gate::define('job-edit', function ($user) {
            return $user->job_permissions[1] || $user->role_id == 0 || $user->role_id == 1;
        });
        Gate::define('job-delete', function ($user) {
            return $user->job_permissions[2] || $user->role_id == 0 || $user->role_id == 1;
        });
        Gate::define('job-view', function ($user) {
            return $user->job_permissions[3] || $user->role_id == 0 || $user->role_id == 1;
        });

        // Payout Policies
        Gate::define('payout-add', function ($user) {
            return $user->payout_permissions[0] || $user->role_id == 0;
        });
        Gate::define('payout-edit', function ($user) {
            return $user->payout_permissions[1] || $user->role_id == 0;
        });
        Gate::define('payout-delete', function ($user) {
            return $user->payout_permissions[2] || $user->role_id == 0;
        });
        Gate::define('payout-view', function ($user) {
            return $user->payout_permissions[3] || $user->role_id == 0;
        });

        // Recipient Policies
        Gate::define('recipient-add', function ($user) {
            return $user->recipient_permissions[0] || $user->role_id == 0;
        });
        Gate::define('recipient-edit', function ($user) {
            return $user->recipient_permissions[1] || $user->role_id == 0;
        });
        Gate::define('recipient-delete', function ($user) {
            return $user->recipient_permissions[2] || $user->role_id == 0;
        });
        Gate::define('recipient-view', function ($user) {
            return $user->recipient_permissions[3] || $user->role_id == 0;
        });

        // Reports Policies
        Gate::define('reports-add', function ($user) {
            return $user->reports_permissions[0] || $user->role_id == 0;
        });
        Gate::define('reports-edit', function ($user) {
            return $user->reports_permissions[1] || $user->role_id == 0;
        });
        Gate::define('reports-delete', function ($user) {
            return $user->reports_permissions[2] || $user->role_id == 0;
        });
        Gate::define('reports-view', function ($user) {
            return $user->reports_permissions[3] || $user->role_id == 0;
        });

        // Push Policies
        Gate::define('push-add', function ($user) {
            return $user->push_permissions[0] || $user->role_id == 0;
        });
        Gate::define('push-edit', function ($user) {
            return $user->push_permissions[1] || $user->role_id == 0;
        });
        Gate::define('push-delete', function ($user) {
            return $user->push_permissions[2] || $user->role_id == 0;
        });
        Gate::define('push-view', function ($user) {
            return $user->push_permissions[3] || $user->role_id == 0;
        });

        // Settings Policies
        Gate::define('settings-add', function ($user) {
            return $user->settings_permissions[0] || $user->role_id == 0;
        });
        Gate::define('settings-edit', function ($user) {
            return $user->settings_permissions[1] || $user->role_id == 0;
        });
        Gate::define('settings-delete', function ($user) {
            return $user->settings_permissions[2] || $user->role_id == 0;
        });
        Gate::define('settings-view', function ($user) {
            return $user->settings_permissions[3] || $user->role_id == 0;
        });

//        Passport::tokensExpireIn(Carbon::now()->addDays(15));
//
//        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        //
    }
}
