<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetHistory;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            $user = Auth::user();
            if (!$user->hasPermissionTo('aset-create')) {
                $asset = $asset->where('asset_used_by', $user->user_id);
            }
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
    public function show(Request $request, string $id)
    {
        if($request->ajax()) {
            $isTransform = $request->query('transform') ?? false;
            $asset = Asset::query()->with(
            'asset_category',
            'item_category',
            'item',
            'item_type',
            'item_brand',
            'asal_pengadaan',
            'bahan',
            'satuan',
            'asal_oleh',
            'user')->where('asset_id', $id)->first();
            if (!$isTransform) return response()->json([ 'status' => true, 'data' => ['asset'=>$asset]], 200);
            $asset = Asset::transform($asset);
            $history = AssetHistory::with(['historyable','historyable.user'])->where('asset_id', $id)->orderBy('asset_history_id', 'asc')->get();
            $peminjaman = Peminjaman::where('asset_id', $id)->orderBy('asset_peminjaman_id', 'asc')->get();
            return response()->json([ 'status' => true, 'data' => ['asset'=>$asset, 'history'=>$history, 'peminjaman'=>$peminjaman]], 200);
        }
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
        // 'item_type_name' => "required|unique:item_types,item_type_name,$id,item_type_id,item_brand_id,$request->item_brand_id,deleted_at,NULL",

        $this->validate($request, [
            'asset_serial_number' => "nullable|unique:assets,asset_serial_number,$id,asset_id,deleted_at,NULL",
        ],
        [
            'asset_serial_number.unique' => 'Serial number sudah digunakan',
        ]);
        $input = $request->all();
        try {
            DB::beginTransaction();
                $input['asset_id'] = $id;
                $data = Asset::normalize($input);
                Asset::updateAsset($data);
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
                AssetHistory::where('asset_id', $id)->delete();
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
            $asset = Asset::select('asset_id', 'asset_name')
                ->where('asset_status', 'TERSEDIA')
                ->when($request->search, function($query, $keyword) {
                    $keyword = strtolower($keyword);
                    $query->whereRaw('LOWER(asset_name) LIKE ? ',['%'.$keyword.'%']);

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
