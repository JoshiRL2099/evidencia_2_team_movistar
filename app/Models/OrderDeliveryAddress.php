<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrderDeliveryAddress extends Model
{
    protected $table = 'order_delivery_addresses';
    protected $primaryKey = 'order_address_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'order_address_id',
        'street',
        'ext_number',
        'int_number',
        'neighborhood',
        'city',
        'state',
        'zip',
        'references',
        'order_id',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->order_address_id)) {
                $model->order_address_id = (string) Str::uuid();
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}