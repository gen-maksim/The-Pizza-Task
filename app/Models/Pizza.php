<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $fillable = ['name', 'description', 'cost', 'picture'];

    /**
     * Retrieving column from pivot table for Order relation
     * @return integer|null
     */
    public function getCountAttribute()
    {
        if ($this->pivot) {
            return $this->pivot->count;
        }
        return null;
    }
}
