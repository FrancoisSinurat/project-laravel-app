<?php

namespace App\Http\Controllers;

use App\Models\ItemBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ItemBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function ajax(Request $request)
    {
        try {
            $brand = ItemBrand::select('item_brand_id', 'item_id', 'item_brand_name')
                ->when($request->search, function($query, $keyword) {
                    $query->where("item_brand_name", "like", "%$keyword%");
                })
                ->when($request->item, function($query, $item) {
                    $query->where('item_id', $item);
                }, function($query) {
                    $query->whereNull('item_id');
                })
                ->limit(10)
                ->get();
            if($brand->isNotEmpty()) {

                return response()->json([
                    'results' => $brand
                ], 200);
            }


            return response()->json([], 200);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
        }
    }
}
