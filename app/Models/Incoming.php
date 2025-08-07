<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incoming extends Model
{
    protected $fillable = [
        'material_name', 
        'quantity',
        'satuan',
    ];

    public function productions()
    {
        return $this->hasMany(Production::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'productions')
            ->withPivot(['quantity_used', 'quantity_produced'])
            ->withTimestamps();
    }
}