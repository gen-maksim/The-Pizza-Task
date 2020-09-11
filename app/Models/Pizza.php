<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $fillable = ['name', 'description', 'cost', 'picture'];
    protected $appends = ['pic_url'];

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

    public function getPicUrlAttribute()
    {
        return asset("pics/$this->picture.jpg");
    }
}
