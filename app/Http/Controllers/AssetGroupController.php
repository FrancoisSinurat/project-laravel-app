<?php

namespace App\Http\Controllers;

use App\Models\AssetGroup;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AssetGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:asset-group-list', ['only' => ['index']]);
        $this->middleware('permission:asset-group-create', ['only' => ['store']]);
        $this->middleware('permission:asset-group-edit', ['only' => ['update']]);
        $this->middleware('permission:asset-group-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $assetgroups = AssetGroup::query()->with('asset', 'asal_oleh', 'asal_pengadaan');
            return DataTables::of($assetgroups)->make();
        }
        return view('asset-group.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $input = $request->all();
        try {
            DB::beginTransaction();
            $data = AssetGroup::normalize($input);
            AssetGroup::updateorCreateAssetGroup($data);
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
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
     * update
     *
     * @param  mixed $request
     * @return void
     */
    public function update(Request $request)
    {
        $input = $request->all();
        // $assetgroups = AssetGroup::findorFail($request->asset_group_id);
        // $input = $assetgroups->update([
        //     'asset_group_number' => $request->input('asset_group_number'),
        //     'asalpengadaan_category_id' => $request->input('asalpengadaan_category_id'),
        //     'asaloleh_category_id' => $request->input('asaloleh_category_id'),
        //     'asset_asaloleh_date' => $request->input('asset_asaloleh_date'),
        //     'asset_procurement_year' => $request->input('asset_procurement_year'),
        //     'asset_documents' => $request->input('asset_documents'),
        //     'asset_group_items' => $request->input('asset_group_items')
        // ]);
        try {
            DB::beginTransaction();
            $data = AssetGroup::normalize($input);
            AssetGroup::updateAssetGroup($data);
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
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
            DB::beginTransaction();
            AssetGroup::deleteAsset($id);
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json([
                'status' => true,
            ], 500);
        }
    }

    public function ajax(Request $request)
    {
        try {
            $asset = AssetGroup::with('asal_oleh', 'asal_pengadaan')
                ->when($request->search, function ($query, $keyword) {
                    $keyword = strtolower($keyword);
                    $query->whereRaw('LOWER(asset_document_number) LIKE ? ', ['%' . $keyword . '%']);
                })
                ->limit(10)
                ->get();
            if ($asset->isNotEmpty()) {
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
