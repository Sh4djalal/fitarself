<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index(Request $request)
    {
        $query = Part::query()->where('in_stock', true);

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }
        if ($request->has('condition')) {
            $query->where('condition', $request->condition);
        }
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name_en', 'like', '%' . $request->search . '%')
                  ->orWhere('part_number', 'like', '%' . $request->search . '%');
            });
        }

        $parts = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = Part::select('category')->distinct()->pluck('category');

        return view('parts.index', compact('parts', 'categories'));
    }

    public function show(Part $part)
    {
        $relatedParts = Part::where('category', $part->category)
            ->where('id', '!=', $part->id)
            ->limit(6)
            ->get();

        return view('parts.show', compact('part', 'relatedParts'));
    }
}