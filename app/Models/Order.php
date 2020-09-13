<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'cost', 'currency_type', 'delivery_needed', 'address', 'phone', 'user_name'];
    protected $casts = ['created_at' => 'datetime'];

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class)->withPivot('count');
    }
}
