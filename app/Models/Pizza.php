<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    protected $fillable = [
        'name', 'description', 'cost', 'picture'
    ];

    protected $appends = [
        'pic_url'
    ];

    /**
     * Retrieving column from pivot table for Order relation
     *
     * @return integer|null
     */
    public function getCountAttribute(): ?int
    {
        if ($this->pivot) {
            return $this->pivot->count;
        }

        return null;
    }

    /**
     * Accessor for pic url. Basically for vue
     *
     * @return string
     */
    public function getPicUrlAttribute(): string
    {
        return asset("pics/$this->picture.jpg");
    }
}
