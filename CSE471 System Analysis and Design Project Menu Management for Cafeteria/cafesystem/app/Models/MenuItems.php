<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItems extends Model
{
    use HasFactory;

    protected $table = 'menuitems';
    public $timestamps = false;
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'photo_url',
        'popularity_score',
        'is_available',
    ];
}