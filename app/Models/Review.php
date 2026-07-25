<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'event_id',
        'transaction_id',
        'reviewer_name',
        'reviewer_email',
        'rating',
        'comment',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}