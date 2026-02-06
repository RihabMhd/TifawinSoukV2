<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StockController extends Controller
{
    public function adjust(Request $request, Product $product)
    {
        $data = $request->validate([
            'type' => 'required',
            'quantity' => 'required|min:10',
            'reason' => 'string',
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
                'reason' => $data['reason']
            ]);
        });

    }
}
