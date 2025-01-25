<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $table = 'orderitems';
    protected $primaryKey = 'order_item_id';
    protected $fillable = ['order_id', 'item_id', 'quantity', 'price'];
    public $timestamps = false;
}
