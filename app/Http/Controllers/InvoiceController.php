<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Display a listing of the Invoices
    public function index()
    {
        return Invoice::orderBy('created_at', 'desc')->get();
    }

    // Store a newly created Invoice in storage
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'quantity' => 'required',
            'price' => 'required',
            'product' => 'required',
            'totalPrice' => 'required',
            'client' => 'required',
            'pro_id' => 'required',
            'date' => 'required|date'
        ]);

        $Invoice = Invoice::create($validatedData);
        return response()->json($Invoice, 201);
    }

    // Display the specified Invoice
    public function show(Request $request)
{
    // Reading query string parameters
    $clientId = $request->query('clientId');
    $start_date = $request->query('start_date');
    $end_date = $request->query('end_date');

    // Process the parameters as needed
    if ($clientId) {
        $invoices = Invoice::where('client', $clientId)->get();
        return response()->json($invoices);
    }

    if ($start_date && $end_date) {
        $orders = Invoice::whereBetween('date', [$start_date, $end_date])->get();
        $product = Invoice::whereBetween('date', [$start_date, $end_date])
        ->selectRaw('product, COUNT(product) as product_count')
        ->groupBy('product')
        ->orderByDesc('product_count')
        ->first();
        $sales = Invoice::whereBetween('date', [$start_date, $end_date])->sum('totalPrice');

        return response()->json(['orders'=>$orders,'sales'=>$sales,'product'=>$product]);
    }

    return response()->json(['message' => 'Invalid parameters'], 400);
}



    public function update(Request $request, Invoice $Invoice)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|min:1',
            'price' => 'required',
            'product' => 'required',
            'totalPrice' => 'required',
            'client' => 'required',
            'pro_id' => 'required',
            'date' => 'required|date'
        ]);

        $Invoice->update($validatedData);
        return response()->json($Invoice);
    }

        public function destroy(Invoice $Invoice)
    {
        $Invoice->delete();
        return response()->json(null, 204);
    }
}
