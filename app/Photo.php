<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'name'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
