<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetGroup;
use App\Models\AssetHistory;
use App\Models\AssetTemporary;
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

            $asset = Asset::query()->with('asset_group', 'item', 'satuan', 'user')->where('assets.item_category_id', $request->categoryId);
            $user = Auth::user();
            if (!$user->hasPermissionTo('aset-create')) {
                $asset = $asset->where('assets.asset_used_by', $user->user_id);
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
            // 'asset_serial_number' => 'nullable|unique:assets,asset_serial_number,NULL,NULL,deleted_at,NULL',
            'asset_document_number' => 'required',
        ],
        [
            // 'asset_serial_number.unique' => 'Serial number sudah digunakan',
            'asset_document_number' => 'Nomor dokumen wajib diisi'
        ]);
        $input = $request->all();
        $newInput = [];
        try {
            $user = Auth::user();
            $checkDocNumber = AssetGroup::where('asset_document_number', $input['asset_document_number'])->first();
            if ($checkDocNumber) $input['asset_group_id'] = $checkDocNumber->asset_group_id;
            $getListCode = AssetTemporary::where('asset_temporary_user_id', $user->user_id)->get();
            if (count($getListCode) == 0) throw new \Exception('Minimal 1 item');
            foreach ($getListCode as $k => $v) {
                $input['asset_id'][] = $v->asset_temporary_id;
                $input['asset_bpad_code'][] = $v->asset_temporary_bpad_code;
                $input['asset_serial_number'][] = $v->asset_temporary_serial_number;
                $input['asset_machine_number'][] = $v->asset_temporary_machine_number;
                $input['asset_frame_number'][] = $v->asset_temporary_frame_number;
                $input['asset_police_number'][] = $v->asset_temporary_police_number;
            }
            if (count($input['asset_serial_number']) >= 0) {
                $newInput = Asset::populateAsset($input);
            }
            DB::beginTransaction();
                if (count($newInput) > 0) {
                    for ($i=0; $i < count($newInput['asset']); $i++) {
                        $newInput['asset'][$i] = Asset::normalize($newInput['asset'][$i]);
                    }
                    Asset::createBulkAsset($newInput);
                }
                AssetTemporary::where('asset_temporary_user_id', $user->user_id)->delete();
                // else {
                //     $data = Asset::normalize($input);
                //     Asset::createAsset($data);
                // }
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
    public function show(Request $request, string $id)
    {
        if($request->ajax()) {
            $isTransform = $request->query('transform') ?? false;
            $asset = Asset::query()->with(
            'asset_group',
            'asset_category',
            'item_category',
            'item',
            'item_type',
            'item_brand',
            'asset_group.asal_pengadaan',
            'bahan',
            'satuan',
            'location',
            'asset_group.asal_oleh',
            'user')->where('asset_id', $id)->first();
            if (!$isTransform) return response()->json([ 'status' => true, 'data' => ['asset'=>$asset]], 200);
            $asset = Asset::transform($asset);
            $history = AssetHistory::with(['historyable','historyable.user'])->where('asset_id', $id)->orderBy('asset_history_id', 'asc')->get();
            $peminjaman = Peminjaman::with(['user'])->where('asset_id', $id)->orderBy('asset_peminjaman_id', 'asc')->get();
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
                Asset::deleteAsset($id);
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
            ->where('asset_status', '!=', 'DIGUNAKAN')
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
