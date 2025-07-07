<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price_at_sale',
        'subtotal',
    ];

    /**
     * Mendapatkan produk yang terkait dengan detail penjualan ini.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

