<?php

namespace App\Http\Controllers;

use App\Models\AssetGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssetGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:aset-list', ['only' => ['index']]);
        $this->middleware('permission:aset-create', ['only' => ['store']]);
        $this->middleware('permission:aset-edit', ['only' => ['update']]);
        $this->middleware('permission:aset-delete', ['only' => ['destroy']]);
    }
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
            $asset = AssetGroup::with('asal_oleh', 'asal_pengadaan')
            ->when($request->search, function($query, $keyword) {
                $keyword = strtolower($keyword);
                $query->whereRaw('LOWER(asset_document_number) LIKE ? ',['%'.$keyword.'%']);
            })
            ->limit(10)
            ->get();
            if($asset->isNotEmpty()) {
                return response()->json([
                    'results' => $asset
                ], 200);
            }
            return response()->json([], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
