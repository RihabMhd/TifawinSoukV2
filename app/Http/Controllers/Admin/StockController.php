<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;


class StockController extends Controller
{
    public function dashboard(){
        $product_rupture = Product::where('quantity',0)->get();
        $product_stock_critique = Product::where('quantity', '>',0)->whereColumn('quantity','<','stock_alert_threshold')->get();
        $product_valeur_inventaire = Product::sum(DB::raw('quantity * price'));
        return view('admin.stocks.dashboard',compact('product_rupture','product_stock_critique','product_valeur_inventaire'));
    } 
    public function adjust(Request $request, Product $product)
    {
        $data = $request->validate([
            'stock_alert_threshold' => 'required',
            'quantity' => 'required'
            ]);
        // transaction hadi katkhelik dir joj ola kter mn query bax ikhedmo bjoj o ila we7da fihom makhedmatch maghaykhdem ta wa7ed 
        // dik ->increment hiya ikhtissar l ( update product set quantity = quantity + $quantity where ...)
        DB::transaction(function () use ($product, $data) {
            $product->increment('quantity', $data['quantity']);
            StockMovement::create([
                'product_id'=> $product->id,
                'user_id' => auth()->id(),
                'type' => 'adjustment',
                'quantity' => $data['quantity'],
                'stock_alert_threshold' => $data['stock_alert_threshold']
            ]);
        });

        return redirect()->route('admin.stock.dashboard');

    }
    public function edit(string $id){
        $product = Product::findOrFail($id);
        return view('admin.stocks.adjust',compact('product'));
    }
}
