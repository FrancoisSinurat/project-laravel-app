<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class ItemCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $item = ItemCategory::query()->with('asset_category');
            return DataTables::of($item)->make();
        }
        $assetCategory = AssetCategory::get();
        return view('item-category.index', compact('assetCategory'));
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
        $this->validate($request, [
            'item_category_name' => 'required|unique:item_categories,item_category_name,NULL,NULL,deleted_at,NULL',
            'item_category_code' => 'required|unique:item_categories,item_category_code,NULL,NULL,deleted_at,NULL',
            'asset_category_id' => 'required',
        ],
        [
            'item_category_name.unique' => 'Nama Jenis barang sudah ada',
            'item_category_code.unique' => 'Kode Jenis barang sudah ada'
        ]);
        try {
            $input = $request->all();
            $input['item_category_code'] = strtoupper($input['item_category_code']);
            ItemCategory::create($input);
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'status' => false,
                'data' => $th,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
        $this->validate($request, [
            'item_category_name' => "required|unique:item_categories,item_category_name,$id,item_category_id,deleted_at,NULL",
            'item_category_code' => "required|unique:item_categories,item_category_code,$id,item_category_id,deleted_at,NULL",
            'asset_category_id' => 'required',
        ],
        [
            'item_category_name.unique' => 'Nama Jenis barang sudah ada',
            'item_category_code.unique' => 'Kode Jenis barang sudah ada'
        ]);
        $input = $request->all();
        $input['item_category_code'] = strtoupper($input['item_category_code']);
        try {
            ItemCategory::where('item_category_id', $id)->update($input);
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'status' => false,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                ], 500);
            }
            ItemCategory::where('item_category_id', $id)->delete();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json([
                'status' => false,
            ], 500);
        }
    }
}
