<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'menu_id',
        'can_view',
        'can_add',
        'can_update',
        'can_delete',
    ];

    /**
     * Get the role associated with the permission.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the menu associated with the permission.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
