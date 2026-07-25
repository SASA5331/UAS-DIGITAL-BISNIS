<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo_url', 'description', 'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function totalRevenue()
    {
        return Transaction::whereIn('event_id', $this->events()->pluck('id'))
                ->whereIn('status', ['settlement', 'success'])
                ->sum('total_price');
    }
}