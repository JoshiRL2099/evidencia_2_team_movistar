<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'username',
        'password_hash',
        'full_name',
        'email',
        'is_active',
        'created_at',
        'role_id',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->user_id)) {
                $model->user_id = (string) Str::uuid();
            }
        });
    }

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function createdOrders()
    {
        return $this->hasMany(Order::class, 'created_by_user_id', 'user_id');
    }

    public function uploadedPhotos()
    {
        return $this->hasMany(Photo::class, 'uploaded_by_user_id', 'user_id');
    }

    public function statusChanges()
    {
        return $this->hasMany(OrderStatusHistory::class, 'changed_by_user_id', 'user_id');
    }
}