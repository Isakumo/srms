<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'must_change_password' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id')
            ->via('roles');
    }

    public function hasRole(string $roleCode): bool
    {
        return $this->roles()->where('code', $roleCode)->exists();
    }

    public function hasPermission(string $permissionCode): bool
    {
        return $this->roles()
            ->join('role_permissions', 'role_permissions.role_id', '=', 'roles.id')
            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
            ->where('permissions.code', $permissionCode)
            ->exists();
    }

    public function hasSchoolAccess(int $schoolId): bool
    {
        if ($this->school_id === null) {
            return true;
        }

        return (int) $this->school_id === (int) $schoolId;
    }

    public function isActive(): bool
    {
        return strtolower((string) $this->status) === 'active';
    }
}
