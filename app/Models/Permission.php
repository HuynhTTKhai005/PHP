<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
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
     * Quan hệ: Một Permission thuộc về nhiều Role (Many-to-Many)
     * Sử dụng bảng trung gian role_permissions
     */
    public function roles()
    {
        return $this->belongsToMany(
            Role::class,
            'role_permissions',
            'permission_id',
            'role_id'
        )->withTimestamps();
    }

    /**
     * Kiểm tra permission có được gán cho role nào đó không
     */
    public function isAssignedToRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Kiểm tra permission có được gán cho bất kỳ role nào không
     */
    public function isUsed(): bool
    {
        return $this->roles()->exists();
    }

    /**
     * Scope để tìm permission theo tên
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * Scope để tìm nhiều permission theo mảng tên
     */
    public function scopeWhereNames($query, array $names)
    {
        return $query->whereIn('name', $names);
    }

    /**
     * Lấy danh sách role name mà permission này được gán
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAssignedRolesAttribute()
    {
        return $this->roles->pluck('name');
    }
}
