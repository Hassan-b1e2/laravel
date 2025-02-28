<?php

namespace App\Http\Controllers;

use App\Models\Supplierbl;

use Illuminate\Http\Request;

class SupplierBlController extends Controller
{
    public function index()
    {
        return Supplierbl::selectRaw('bl, MAX(created_at) as latest_created_at')
        ->groupBy('bl')
        ->orderBy('latest_created_at', 'desc')
        ->get();    
        }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'product' => 'required|string',
                'price' => 'required|numeric|min:0',
                'totalPrice' => 'required|numeric|min:0',
                'supplier' => 'required|string',
                'quantity' => 'required|integer|min:1',
                'supp_id' => 'required|integer',
                'bl' => 'required|string',
            ]);

        Supplierbl::create($validatedData);

        return response()->json(['message' => 'Supplier added successfully'], 201);
    }

    public function show(Request $request)
    {
        $supp_id = $request->query('id');
        $supp = $request->query('supp');

        $bl = $request->query('bl');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');   
        

        if ($supp_id) {
        $supp = Supplierbl::where('supp_id',$supp_id)->select('bl')->groupBy('bl')->get();
            return response()->json($supp);
        }
        if ($bl) {
        $bls = Supplierbl::where('bl',$bl)->get();
        return response()->json($bls);
            }

            if ($start_date && $end_date && $supp) {
                $bls = Supplierbl::whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->where('supp_id', $supp)
        ->sum('totalPrice');


                return response()->json($bls);
                    }
            
    
        return response()->json(['message' => 'Invalid parameters'], 400);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplierbl::find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }

        $validatedData = $request->validate([
            'product' => 'required|string',
            'price' => 'required|numeric|min:0',
            'totalPrice' => 'required|numeric|min:0',
            'supplier' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'supp_id' => 'required|integer',
            'bl' => 'required|string',
        ]);

        

        $supplier->update($validatedData);

        return response()->json(['message' => 'Supplier updated successfully']);
    }

    public function destroy($id)
    {
        $supplier = Supplierbl::find($id);
        if (!$supplier) {
            return response()->json(['message' => 'Supplier not found'], 404);
        }

        $supplier->delete();

        return response()->json(['message' => 'Supplier deleted successfully']);
    }
}
