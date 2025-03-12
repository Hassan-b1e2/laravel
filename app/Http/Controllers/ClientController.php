<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Stock;

class ClientController extends Controller
{
    public function index()
    {
        return Client::orderBy('created_at', 'desc')->get();
    }

    public function show(Request $request)
    {
        $clientId = $request->query('clientId');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $status = $request->query('status');

        if ($status) {
            if($status=='local'){
            $clients = Client::where('status', $status)->get();
            return response()->json($clients);
        }else{
            $clients = Client::whereNot('status', 'local')->get();
            return response()->json($clients);
        }
        }
    
        if ($clientId) {
            $client = Client::where('id', $clientId)->get();
            return response()->json($client);
        }
    
        if ($start_date && $end_date) {
            $city = Client::whereNotNull('city')
            ->selectRaw('city, COUNT(city) as city_count')
            ->groupBy('city')
            ->orderByDesc('city_count')
            ->take(5)
            ->get();

            $client = Client::whereNotNull('name')
            ->selectRaw('name, COUNT(name) as name_count')
            ->groupBy('name')
            ->orderByDesc('name_count')
            ->take(5)
            ->get();
            return response()->json(['city'=>$city,'client'=>$client]);
        }
    
        return response()->json(['message' => 'Invalid parameters'], 400);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'ice' => 'required|max:5000',
            'address' => 'required',
            'payment' => 'required',
            'city' => 'required',
            'whatsapp' => 'required',
            'status' => 'required'

        ]);
    
        Client::create($validatedData);
        return response()->json(null, 204);  
    }

    public function update(Client $client,Request $request)
    {
        
        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'ice' => 'required|max:5000',
            'address' => 'required',
            'payment' => 'required',
            'city' => 'required',
            'whatsapp' => 'required',
            'status' => 'required'
        ]);
    
        $client->update($validatedData);
        return response()->json($client);

    }

    public function destroy($id)
{
    $invoices=Invoice::where('client', $id)->get();
    foreach($invoices as $invoice){
        $stock=Stock::find($invoice['pro_id']);
        $newQuantity = $stock->quantity + $invoice['quantity'];
        $stock->update(['quantity' => $newQuantity]);
        $invoice->delete();
    }
    $client = Client::find($id);
    if (!$client) {
        return response()->json(['message' => 'Client not found'], 404);
    }
    $client->delete();

}


}
