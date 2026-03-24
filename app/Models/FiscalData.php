<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FiscalData extends Model
{
    protected $table = 'fiscal_data';
    protected $primaryKey = 'fiscal_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'fiscal_id',
        'rfc',
        'legal_name',
        'tax_regime',
        'cfdi_use',
        'email_for_invoice',
        'customer_id',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->fiscal_id)) {
                $model->fiscal_id = (string) Str::uuid();
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}