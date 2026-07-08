<?php

namespace App\Http\Middleware;

use App\Models\AppSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $setting = AppSetting::getData();

        if (! $setting->maintenance_mode) {
            return $next($request);
        }

        if ($request->routeIs('login', 'login.post', 'logout')) {
            return $next($request);
        }

        $user = $request->user();

        if ($user && $user->isSuperAdmin()) {
            return $next($request);
        }

        abort(503, 'Sistem sedang dalam mode perawatan.');
    }
}
