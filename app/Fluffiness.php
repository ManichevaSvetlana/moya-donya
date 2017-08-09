<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fluffiness extends Model
{
    protected $fillable = [
        'name'
    ];

    public function item(){
        return $this->hasMany(Item::class);
    }
}
