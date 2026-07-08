<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer(['layouts.sidebar', 'layouts.app'], function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $user = \Illuminate\Support\Facades\Auth::user();
                $menus = \App\Models\Menu::getMenuForUser($user);
                $view->with('sidebarMenus', $menus);
            }
        });

        // Share branding and company settings to all views with caching.
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $companySetting = \Illuminate\Support\Facades\Cache::remember('company_settings', 3600, function () {
                return \App\Models\CompanySetting::first();
            });
            $appSetting = \App\Models\AppSetting::getData();

            $view->with('companySetting', $companySetting);
            $view->with('appSetting', $appSetting);
            $view->with('appName', $appSetting->app_name ?: config('app.name'));
        });
    }
}
