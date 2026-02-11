<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'quantity',
        'stock_alert_threshold',
        'image',
        'user_id',
        'category_id',
        'fournisseur_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_product')
            ->withPivot('quantity', 'price_at_addition')
            ->withTimestamps();
    }


    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }


    
    public function getSubtotal(): float
    {
        if (!$this->pivot) {
            return 0;
        }

        return $this->pivot->quantity * $this->pivot->price_at_addition;
    }
}
