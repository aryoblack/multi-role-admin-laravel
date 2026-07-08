<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_menu',
        'url',
        'icon',
        'parent_id',
        'urutan',
    ];

    /**
     * Get the parent menu that owns the menu.
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get the child menus for the menu.
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('urutan');
    }

    /**
     * Get the permissions associated with the menu.
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * Get menu hierarchy for specific user role.
     * Supports up to 3 levels of nesting.
     * 
     * @param User $user
     * @return Collection
     */
    public static function getMenuForUser($user)
    {
        if (!$user || !$user->role_id) {
            return collect([]);
        }

        // Super Admin can see all menus
        if ($user->isSuperAdmin()) {
            return self::whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->orderBy('urutan')
                        ->with(['children' => function ($q) {
                            $q->orderBy('urutan');
                        }]);
                }])
                ->orderBy('urutan')
                ->get();
        }

        // Get permissions for user's role where can_view is true
        $allowedMenuIds = Permission::where('role_id', $user->role_id)
            ->where('can_view', 1)
            ->pluck('menu_id')
            ->toArray();

        if (empty($allowedMenuIds)) {
            return collect([]);
        }

        // Get all menus that user has access to
        $allMenus = self::whereIn('id', $allowedMenuIds)->get();

        // Get parent IDs of allowed menus (to show parent containers even without direct permission)
        $parentIds = $allMenus->pluck('parent_id')->filter()->unique()->toArray();

        // Merge allowed menu IDs with their parent IDs
        $visibleMenuIds = array_unique(array_merge($allowedMenuIds, $parentIds));

        // Get root menus (parent_id is null) that should be visible
        return self::whereNull('parent_id')
            ->where(function ($query) use ($visibleMenuIds, $allowedMenuIds) {
                $query->whereIn('id', $visibleMenuIds)
                    ->orWhereHas('children', function ($q) use ($visibleMenuIds) {
                        $q->whereIn('id', $visibleMenuIds);
                    });
            })
            ->with(['children' => function ($query) use ($visibleMenuIds, $allowedMenuIds) {
                $query->where(function ($q) use ($visibleMenuIds, $allowedMenuIds) {
                    $q->whereIn('id', $visibleMenuIds)
                        ->orWhereHas('children', function ($subq) use ($allowedMenuIds) {
                            $subq->whereIn('id', $allowedMenuIds);
                        });
                })
                    ->orderBy('urutan')
                    ->with(['children' => function ($subquery) use ($allowedMenuIds) {
                        $subquery->whereIn('id', $allowedMenuIds)->orderBy('urutan');
                    }]);
            }])
            ->orderBy('urutan')
            ->get();
    }

    /**
     * Get the first available menu for a user to use as a landing page.
     * 
     * @param User $user
     * @return string
     */
    public static function getLandingPage($user)
    {
        $menus = self::getMenuForUser($user);

        if ($menus->isEmpty()) {
            return '/dashboard'; // Fallback
        }

        $firstMenu = $menus->first();

        // If first menu is a container (url = #), get its first child
        if ($firstMenu->url === '#' && $firstMenu->children->isNotEmpty()) {
            $firstChild = $firstMenu->children->first();

            // Handle deeper nesting if necessary
            if ($firstChild->url === '#' && $firstChild->children->isNotEmpty()) {
                return $firstChild->children->first()->url;
            }

            return $firstChild->url;
        }

        return $firstMenu->url;
    }
}
