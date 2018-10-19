<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'servings', 'caffeine_per_serving',
    ];
}
