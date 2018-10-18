<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserConsumed extends Model
{
    protected $table = 'user_consumed';

    protected $fillable = [
        'user_id', 'drink_id', 'servings_consumed',
    ];

    /**
     * 
     * Relationship to User table
     * 
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
