<?php

namespace App\Models;

use App\Enums\CustomerType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'tax_id',
        'type',
        'is_active',
        'created_by',
    ];

    protected $casts  = [
        'type' => CustomerType::class,
        'is_active' => 'boolean'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
