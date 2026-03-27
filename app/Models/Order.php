<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'name',
        'phone',
        'rfc',
        'address',
        'notes',
        'state',
        'date_time',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function deliveryAddress()
    {
        return $this->hasOne(OrderDeliveryAddress::class, 'order_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->order_id) {
                $model->order_id = (string) Str::uuid();
            }
        });
    }

    // relaciones
    public function address()
    {
        return $this->hasOne(OrderDeliveryAddress::class,'order_id');
    }
    
}