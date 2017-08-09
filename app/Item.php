<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'category_id', 'brand_id', 'fluffiness_id', 'name'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function fluffiness()
    {
        return $this->belongsTo(Fluffiness::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function photo()
    {
        return $this->hasMany(Photo::class);
    }

    public function colour()
    {
        return $this->belongsToMany(Colour::class, 'item_colours', 'item_id', 'colour_id');
    }

    public function size()
    {
        return $this->belongsToMany(Size::class, 'item_sizes', 'item_id', 'size_id');
    }

}
