<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
            'asset_category_name' => 'required|unique:asset_categories,asset_category_name',
        ],
        [
            'asset_category_name.unique' => 'Nama sudah digunakan',
        ]);
        AssetCategory::create($request->all());
        return response()->json([
            'status' => true,
        ], 200);
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
        $this->validate($request, [
            'asset_category_name' => "required|unique:asset_categories,asset_category_name,$id,asset_category_id",
        ],
        [
            'asset_category_name.unique' => 'Nama sudah digunakan',
        ]);
        AssetCategory::where('asset_category_id', $id)->update($request->all());
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
}

