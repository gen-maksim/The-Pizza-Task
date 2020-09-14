<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'cost', 'currency_type', 'delivery_needed', 'address', 'phone', 'user_name'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    /**
     * Return relation to ordered pizzas
     *
     * @return BelongsToMany
     */
    public function pizzas(): BelongsToMany
    {
        return $this->belongsToMany(Pizza::class)->withPivot('count');
    }
}
