<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fournisseur;
class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'price', 'quantity', 'image', 'user_id', 'stock_alert_threshold' , 'category_id', 'fournisseur_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function stockMovement(){
        return $this->hasMany(StockMovement::class);
    }
}
