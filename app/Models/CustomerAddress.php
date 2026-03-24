<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomerAddress extends Model
{
    protected $table = 'customer_addresses';
    protected $primaryKey = 'customer_address_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'customer_address_id',
        'street',
        'ext_number',
        'int_number',
        'neighborhood',
        'city',
        'state',
        'zip',
        'references',
        'customer_id',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->customer_address_id)) {
                $model->customer_address_id = (string) Str::uuid();
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}