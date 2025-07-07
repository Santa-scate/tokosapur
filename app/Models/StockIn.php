<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockIn extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'notes',
    ];

    /**
     * Mendapatkan produk yang terkait dengan catatan stok masuk ini.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Mendapatkan user (admin) yang mencatat stok masuk ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

