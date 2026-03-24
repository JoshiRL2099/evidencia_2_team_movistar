<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'name',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->role_id)) {
                $model->role_id = (string) Str::uuid();
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }
}