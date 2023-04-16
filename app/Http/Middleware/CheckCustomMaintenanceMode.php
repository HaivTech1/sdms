<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Symfony\Component\HttpFoundation\IpUtils;

class CheckCustomMaintenanceMode extends CheckForMaintenanceMode
{
    protected function inExceptArray($request)
    {
        $excepts = [
            // Add your excepted routes here
            'setting',
        ];

        foreach ($excepts as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }

    protected function isDownForMaintenance($request)
    {
        if (! $this->app->isDownForMaintenance()) {
            return false;
        }

        $data = json_decode(file_get_contents($this->app->storagePath().'/framework/down'), true);

        if ($data['secret'] !== $request->cookie('laravel_maintenance')) {
            return true;
        }

        return ! IpUtils::checkIp($request->ip(), (array) $data['allowed']);
    }
}
