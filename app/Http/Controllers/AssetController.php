<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;


class AssetController extends Controller
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
    public function index(Request $request)
    {
        if($request->ajax()) {
            $asset = Asset::query()->with('item', 'satuan', 'user')->where('item_category_id', $request->categoryId);
            return DataTables::of($asset)->make();
        }
        $assetCategory = AssetCategory::get();
        return view('asset.index', compact('assetCategory'));
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
            'asset_serial_number' => 'nullable|unique:assets,asset_serial_number,NULL,NULL,deleted_at,NULL',
        ],
        [
            'asset_serial_number.unique' => 'Serial number sudah digunakan',
        ]);
        $input = $request->all();
        try {
            DB::beginTransaction();
                $data = Asset::normalize($input);
                Asset::createAsset($data);
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
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
        try {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                ], 500);
            }
            DB::beginTransaction();
                Asset::find($id)->delete();
                AssetHistory::where('asset_historyable_id', $id)->where('asset_historyable_type', Asset::class)->delete();
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
}
