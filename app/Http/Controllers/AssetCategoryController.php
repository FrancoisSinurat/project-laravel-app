<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class AssetCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:jenis-aset-list', ['only' => ['index']]);
        $this->middleware('permission:jenis-aset-create', ['only' => ['store']]);
        $this->middleware('permission:jenis-aset-edit', ['only' => ['update']]);
        $this->middleware('permission:jenis-aset-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $asset = AssetCategory::query();
            return DataTables::of($asset)->make();
        }
        return view('asset-category.index');
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
            'asset_category_name' => 'required|unique:asset_categories,asset_category_name,NULL,NULL,deleted_at,NULL',
            'asset_category_code' => 'required|unique:asset_categories,asset_category_code,NULL,NULL,deleted_at,NULL',
        ],
        [
            'asset_category_name.unique' => 'Nama sudah digunakan',
            'asset_category_code.unique' => 'Kode sudah digunakan'
        ]);

        $input = $request->all();
        $input['asset_category_code'] = strtoupper($input['asset_category_code']);
        AssetCategory::create($input);
        return response()->json([
            'status' => true,
        ], 200);
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
            'asset_category_name' => "required|unique:asset_categories,asset_category_name,$id,asset_category_id,deleted_at,NULL",
            'asset_category_code' => "required|unique:asset_categories,asset_category_code,$id,asset_category_id,deleted_at,NULL",
        ],
        [
            'asset_category_name.unique' => 'Nama sudah digunakan',
            'asset_category_code.unique' => 'Kode sudah digunakan'
        ]);

        $input = $request->all();
        $input['asset_category_code'] = strtoupper($input['asset_category_code']);
        AssetCategory::where('asset_category_id', $id)->update($input);
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AssetCategory::where('asset_category_id', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function ajax(Request $request)
    {
        try {
            $assetCategories = AssetCategory::select('asset_category_id', 'asset_category_name')
                ->when($request->search, function($query, $keyword) {
                    $keyword = strtolower($keyword);
                    $query->whereRaw('LOWER(asset_category_name) LIKE ? ',['%'.$keyword.'%']);

                })
                ->limit(10)
                ->get();
            if($assetCategories->isNotEmpty()) {

                return response()->json([
                    'results' => $assetCategories
                ], 200);
            }


            return response()->json([], 200);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
        }
    }
}

