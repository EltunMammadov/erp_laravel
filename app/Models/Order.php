<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;
use App\Models\User;

class Order extends Model
{
    use SoftDeletes;
    protected $table = 'orders';
    
    protected $fillable = [
        'order_number',
        'customer_id',
        'order_date',
        'status',
        'total_amount',
        'discount_pct',
        'net_amount',
        'notes',
        'assigned_to',
        'created_by',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
