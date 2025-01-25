<?php

namespace App\Models\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $primaryKey = 'customer_id'; // Specify the primary key column

    public $incrementing = true; // Set to true if 'customer_id' is auto-incrementing
    protected $keyType = 'int'; // Set the type of the primary key (e.g., 'int', 'string')

    protected $guarded = []; // Optional: Adjust this to allow mass assignment
}
