<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        return Stock::orderBy('created_at', 'desc')->get();
    }

    // Store a newly created stock in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'supplier' => 'required',
            'supplierId' => 'required',
        ]);

        $stock = Stock::create($validatedData);
        return response()->json($stock, 201);
    }

    // Display the specified stock
    public function show(Request $request,Stock $stock)
    {
        
    }

    public function update(Request $request, Stock $stock)
{
    $operation = $request->query('operation');

    if($operation!='empty'){
        $validatedData = $request->validate([
            'quantity' => 'required',
        ]);
        if ($operation == 'add') {
        $newQuantity = $stock->quantity + $validatedData['quantity'];
    } else { 
        $newQuantity = $stock->quantity - $validatedData['quantity'];
    }
    $stock->update(['quantity' => $newQuantity]);
}else{
    $validatedData = $request->validate([
        'name' => 'required',
        'price' => 'required',
    ]);
    $stock->update($validatedData);

}


    return response()->json($stock);
}


    // Remove the specified stock from storage
    public function destroy(Stock $stock)
    {
        $stock->delete();
        return response()->json(null, 204);
    }
}
