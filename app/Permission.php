<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function userPermission ()
    {
        $array =  [
            'Dashboard' => ['dash' => [ 'dashboard-view']],
            'Employees' => ['test' => ['employees-view', 'employees-edit', 'employees-delete', 'employees-add']],
            'Registered Employers' => ['reg-employers-view', 'reg-employers-edit', 'reg-employers-delete', 'reg-employers-add'],
            'Employers' => ['employers-view', 'employers-edit', 'employers-delete', 'employers-add'],
            'Payout' => ['payout-view', 'payout-edit', 'payout-delete', 'payout-add'],
            'Job Management' => ['job-view', 'job-edit', 'job-delete', 'job-add'],
            'Location' => ['location-view', 'location-edit', 'location-delete', 'location-add'],
            'Industry' => ['industry-view', 'industry-edit', 'industry-delete', 'industry-add'],
            'Reports' => ['reports-view', 'reports-edit', 'reports-delete', 'reports-add'],
            'Push Notification' => ['push-view', 'push-edit', 'push-delete', 'push-add'],
            'Recipient Group' => ['receipt-view', 'receipt-edit', 'receipt-delete', 'receipt-add'],
            'Settings' => ['settings-view', 'settings-edit', 'settings-delete', 'settings-add']
            ];

        return $array;
    }

    public function crud()
    {
        $result = ['add', 'edit', 'delete', 'view'];

        return $result;
    }

}
