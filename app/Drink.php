<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    protected $fillable = [
        'name', 'servings', 'caffeine_per_serving',
    ];
}
