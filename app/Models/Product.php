<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function combinations()
    {
        return $this->hasMany(Combination::class)->with('attributes');
    }

    public function attributes()
    {
        return $this->combinations->map->attributes->pluck('category_id');
    }

}
