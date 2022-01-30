<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'user_id', 'name', 'description', 'amount', 'minimum'
    ];
}
