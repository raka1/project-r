<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $fillable = [
        'incoming_id',
        'product_id',
        'quantity_used',
        'quantity_produced',
    ];

    public function incoming()
    {
        return $this->belongsTo(Incoming::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
