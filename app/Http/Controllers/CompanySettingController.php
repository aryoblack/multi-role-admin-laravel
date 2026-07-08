<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    public function index()
    {
        $setting = CompanySetting::first();
        
        // Create default setting if not exists
        if (!$setting) {
            $setting = CompanySetting::create([
                'company_name' => 'Nama Perusahaan',
                'company_address' => '',
                'company_phone' => '',
                'company_email' => '',
                'company_website' => '',
                'company_logo' => null,
                'company_description' => '',
            ]);
        }
        
        return view('company-settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'company_name' => 'required|string|max:255',
                'company_address' => 'nullable|string',
                'company_phone' => 'nullable|string|max:20',
                'company_email' => 'nullable|email|max:255',
                'company_website' => 'nullable|url|max:255',
                'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'company_description' => 'nullable|string',
            ]);

            $setting = CompanySetting::first();
            
            if (!$setting) {
                $setting = new CompanySetting();
            }

            $data = $request->except('company_logo');

            // Handle logo upload
            if ($request->hasFile('company_logo')) {
                // Delete old logo if exists
                if ($setting->company_logo && Storage::disk('public')->exists($setting->company_logo)) {
                    Storage::disk('public')->delete($setting->company_logo);
                }

                $logoPath = $request->file('company_logo')->store('logos', 'public');
                $data['company_logo'] = $logoPath;
            }

            $setting->fill($data);
            $setting->save();

            // Clear cache after update
            Cache::forget('company_settings');

            Log::info('Company settings updated', [
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'changes' => $data,
            ]);

            return redirect()->route('company-settings.index')
                ->with('success', 'Pengaturan perusahaan berhasil diperbarui');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Company settings validation failed', [
                'user_id' => auth()->id(),
                'errors' => $e->errors(),
            ]);
            throw $e;
            
        } catch (\Exception $e) {
            Log::error('Company settings update failed', [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengaturan. Silakan coba lagi.')
                ->withInput();
        }
    }
}
