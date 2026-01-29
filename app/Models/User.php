<?php

namespace App\Models;

 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'password_hash',
        'role_id',
        'loyalty_point',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',   
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at'     => 'datetime',
        'is_active'         => 'boolean',
        'loyalty_point'     => 'integer',
    ];

     public function getAuthPassword()
    {
        return $this->password_hash;
    }

     public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = bcrypt($value);
    }

    // Quan hệ với Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

 
    public function addresses()
    {
         
        return $this->hasMany(Useraddresses::class, 'user_id', 'id');
    }
}