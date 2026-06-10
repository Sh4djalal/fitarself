<?php

namespace App\Http\Controllers;

use App\Models\FaultCode;
use Illuminate\Http\Request;

class FaultCodeController extends Controller
{
    public function index(Request $request)
    {
        $faultCodes = collect();

        if ($request->has('make')) {
            $make = $request->make;
            $faultCodes = FaultCode::where('make', 'All')
                ->orWhere('make', $make)
                ->orderBy('code')
                ->get();
        }

        return view('fault-codes.index', compact('faultCodes'));
    }

    public function show($id)
    {
        $faultCode = FaultCode::findOrFail($id);
        $relatedCodes = FaultCode::where('id', '!=', $id)->limit(6)->get();
        return view('fault-codes.show', compact('faultCode', 'relatedCodes'));
    }
}