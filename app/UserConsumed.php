<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserConsumed extends Model
{
    /**
     * 
     * user_consumed table is not plural, so define table name
     * 
     */
    protected $table = 'user_consumed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    public function drink() {
        return $this->belongsTo(Drink::class);
    }
}
