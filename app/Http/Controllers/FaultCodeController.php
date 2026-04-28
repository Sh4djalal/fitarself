<?php

namespace App\Http\Controllers;

use App\Models\FaultCode;
use Illuminate\Http\Request;

class FaultCodeController extends Controller
{
    public function index(Request $request)
    {
        $query = FaultCode::query();

        if ($request->has('type')) {
            $query->where('code_type', $request->type);
        }
        if ($request->has('severity')) {
            $query->where('severity', $request->severity);
        }
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('title_en', 'like', '%' . $request->search . '%');
            });
        }

       $faultCodes = $query->orderBy('code_type')->orderBy('code')->paginate(100);
        $types = FaultCode::select('code_type')->distinct()->orderBy('code_type')->pluck('code_type');

        return view('fault-codes.index', compact('faultCodes', 'types'));
    }

    public function show(FaultCode $faultCode)
    {
        $faultCode->load('cars');
        $relatedCodes = FaultCode::where('code_type', $faultCode->code_type)
                                 ->where('id', '!=', $faultCode->id)
                                 ->limit(6)
                                 ->get();

        return view('fault-codes.show', compact('faultCode', 'relatedCodes'));
    }
}