<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderStatusHistory extends Model
{
    protected $table = 'order_status_histories';
    protected $primaryKey = 'history_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'history_id',
        'from_status',
        'to_status',
        'changed_at',
        'comment',
        'order_id',
        'changed_by_user_id',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->history_id)) {
                $model->history_id = (string) Str::uuid();
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by_user_id', 'user_id');
    }
}