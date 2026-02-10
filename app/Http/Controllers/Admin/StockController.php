<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function dashboard()
    {
        $product_rupture = Product::where('quantity', 0)->get();
        
        
        $total_value = 0;
        foreach (Product::all() as $product) {
            $total_value += ($product->quantity * $product->price);
        }

        return view('admin.stocks.dashboard', [
            'product_rupture' => $product_rupture,
            'product_valeur_inventaire' => $total_value
        ]);
    }

    public function adjust(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->increment('quantity', $request->quantity);

        return redirect()->route('admin.stock.dashboard');
    }
}