<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'customer_number',
        'display_name',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->customer_id)) {
                $model->customer_id = (string) Str::uuid();
            }
        });
    }

    public function address()
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id', 'customer_id');
    }

    public function fiscalData()
    {
        return $this->hasOne(FiscalData::class, 'customer_id', 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
}