<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $fillable = ['customer_id', 'total_amount', 'payment_status'];
    public $timestamps = false;

    // order_id cast
    protected $casts = [
        'order_id' => 'integer',
    ];
}
