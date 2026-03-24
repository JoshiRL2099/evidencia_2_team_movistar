<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Photo extends Model
{
    protected $table = 'photos';
    protected $primaryKey = 'photo_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'photo_id',
        'type',
        'url',
        'uploaded_at',
        'order_id',
        'uploaded_by_user_id',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->photo_id)) {
                $model->photo_id = (string) Str::uuid();
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id', 'user_id');
    }
}