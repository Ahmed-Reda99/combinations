<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combination extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
