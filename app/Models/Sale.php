<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Good;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['good_id', 'quantity_sold', 'sale_date'];

    protected $casts = [
        'sale_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function good()
    {
        return $this->belongsTo(Good::class);
    }

    protected static function booted()
    {
        static::creating(function ($sale) {
            $good = Good::find($sale->good_id);
            $sale->total_amount = $sale->quantity_sold * $good->selling_price;
            $sale->profit = $sale->quantity_sold * ($good->selling_price - $good->buying_price);
            $sale->sale_date = now();

            // Decrease stock
            $good->decrement('stock_quantity', $sale->quantity_sold);
        });
    }
}





