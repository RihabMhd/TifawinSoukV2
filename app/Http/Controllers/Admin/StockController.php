<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

<<<<<<< HEAD

=======
>>>>>>> 370a1a4804ab132294fd011825271f9be2f72a16
class StockController extends Controller
{
    public function dashboard()
    {
        $product_rupture = Product::where('quantity', 0)->get();
        
        $product_stock_critique = Product::whereColumn('quantity', '<=', 'stock_alert_threshold')
            ->where('quantity', '>', 0)
            ->get();
        
        $total_value = 0;
        foreach (Product::all() as $product) {
            $total_value += ($product->quantity * $product->price);
        }

        return view('admin.stocks.dashboard', [
            'product_rupture' => $product_rupture,
            'product_stock_critique' => $product_stock_critique,
            'product_valeur_inventaire' => $total_value
        ]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        return view('admin.stocks.adjust', [
            'product' => $product
        ]);
    }

    public function adjust(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
            'stock_alert_threshold' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        
        $product->update([
            'quantity' => $request->quantity,
            'stock_alert_threshold' => $request->stock_alert_threshold
        ]);

        return redirect()
            ->route('admin.stock.dashboard')
            ->with('success', 'Stock updated successfully for ' . $product->title);
    }
}