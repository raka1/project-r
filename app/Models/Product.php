<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'name',
        'stock',
        'price',
    ];

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function incomings()
    {
        return $this->belongsToMany(Incoming::class, 'productions')
            ->withPivot(['quantity_used', 'quantity_produced'])
            ->withTimestamps();
    }
}