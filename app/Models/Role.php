<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Các thuộc tính có thể được mass assignment
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Quan hệ: Một Role thuộc về nhiều User
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Quan hệ: Một Role có nhiều Permission (Many-to-Many)
     * Sử dụng bảng trung gian role_permissions
     */
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'role_id',
            'permission_id'
        )->withTimestamps();
    }

    /**
     * Gán một hoặc nhiều permission cho role
     * Dễ dùng trong controller hoặc seeder
     *
     * @param string|array $permissionNames
     * @return void
     */
    public function givePermissionTo($permissionNames)
    {
        $permissions = Permission::whereIn('name', (array) $permissionNames)->get();

        if ($permissions->isNotEmpty()) {
            $this->permissions()->syncWithoutDetaching($permissions);
        }
    }

    /**
     * Xóa một hoặc nhiều permission khỏi role
     *
     * @param string|array $permissionNames
     * @return void
     */
    public function revokePermissionTo($permissionNames)
    {
        $permissions = Permission::whereIn('name', (array) $permissionNames)->get();

        if ($permissions->isNotEmpty()) {
            $this->permissions()->detach($permissions);
        }
    }

    /**
     * Kiểm tra role có permission nào đó không
     *
     * @param string $permissionName
     * @return bool
     */
    public function hasPermissionTo(string $permissionName): bool
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }

    /**
     * Scope để lấy role theo tên
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }
}
