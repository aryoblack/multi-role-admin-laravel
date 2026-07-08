<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Support\PermissionResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AppSettingController extends Controller
{
    public function index()
    {
        $setting = AppSetting::getData();
        $pagePermission = PermissionResolver::forPath(request()->user(), '/app-settings');

        return view('app-settings.index', compact('setting', 'pagePermission'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'app_favicon' => 'nullable|image|mimes:ico,png,jpg|max:512',
            'primary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'footer_text' => 'nullable|string|max:255',
            'allow_registration' => 'boolean',
            'maintenance_mode' => 'boolean',
        ]);

        try {
            $setting = AppSetting::first() ?: new AppSetting();

            // Handle Checkboxes (since they don't send anything if unchecked)
            $data['allow_registration'] = $request->has('allow_registration');
            $data['maintenance_mode'] = $request->has('maintenance_mode');

            // Handle uploads
            if ($request->hasFile('app_logo')) {
                if ($setting->app_logo) Storage::disk('public')->delete($setting->app_logo);
                $data['app_logo'] = $request->file('app_logo')->store('app', 'public');
            }

            if ($request->hasFile('app_favicon')) {
                if ($setting->app_favicon) Storage::disk('public')->delete($setting->app_favicon);
                $data['app_favicon'] = $request->file('app_favicon')->store('app', 'public');
            }

            $setting->fill($data);
            $setting->save();

            // Clear cache
            Cache::forget('app_settings');

            return redirect()->back()->with('success', 'Pengaturan aplikasi berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('App settings update failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Gagal memperbarui pengaturan. Silakan coba lagi.');
        }
    }
}
