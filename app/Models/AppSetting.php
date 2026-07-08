<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'app_name',
        'app_logo',
        'app_favicon',
        'primary_color',
        'secondary_color',
        'footer_text',
        'allow_registration',
        'maintenance_mode',
    ];

    protected $casts = [
        'allow_registration' => 'boolean',
        'maintenance_mode' => 'boolean',
    ];

    /**
     * Get app settings from the database.
     */
    public static function getData(): self
    {
        return self::first() ?: self::create([
            'app_name' => config('app.name', 'Laravel'),
            'primary_color' => '#2563eb',
            'secondary_color' => '#1d4ed8',
            'footer_text' => '© ' . date('Y') . ' ' . config('app.name', 'Laravel') . '. All Rights Reserved.',
            'allow_registration' => false,
            'maintenance_mode' => false,
        ]);
    }
}
