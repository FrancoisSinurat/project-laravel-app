<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:barang-list', ['only' => ['index']]);
        $this->middleware('permission:barang-create', ['only' => ['store']]);
        $this->middleware('permission:barang-edit', ['only' => ['update']]);
        $this->middleware('permission:barang-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $item = Item::query()->with('item_category');
            return DataTables::of($item)->make();
        }
        $itemCategory = ItemCategory::get();
        return view('item.index', compact('itemCategory'));
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
            'item_name' => 'required|unique:items,item_name,NULL,NULL,deleted_at,NULL',
            'item_category_id' => 'required',
        ],
        [
            'item_name.unique' => 'Nama jenis barang sudah digunakan',
        ]);

        $input = $request->all();

        if (empty($input['item_code'])) {
            date_default_timezone_set("Asia/Jakarta");
            $tgl = date("dmY");
            $getLastNumber = Item::where('item_category_id', $input['item_category_id'])->count();
            $lastNumber = $getLastNumber ? intval($getLastNumber) + 1 : 1;
            $code = str_pad($lastNumber, 5, '0', STR_PAD_LEFT);
            $itemCategory = ItemCategory::where('item_category_id', $input['item_category_id'])->first();
            $itemCode = $itemCategory->item_category_code.'-'.$tgl.'-'.$code;
            $input['item_code'] = $itemCode;
        }

        Item::create($input);
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
            'item_name' => "required|unique:items,item_name,$id,item_id,deleted_at,NULL",
            'item_code' => "required|unique:items,item_code,$id,item_id,deleted_at,NULL",
            'item_category_id' => 'required',
        ],
        [
            'item_name.unique' => 'Nama jenis barang sudah digunakan',
            'item_code.unique' => 'Kode jenis barang sudah digunakan'
        ]);
        $input = $request->all();
        $input['item_code'] = strtoupper($input['item_code']);
        Item::where('item_id', $id)->update($input);
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Item::where('item_id', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function ajax(Request $request)
    {
        try {
            $item = Item::select('item_id', 'item_category_id', 'item_name', 'item_code')
                ->when($request->search, function($query, $keyword) {
                    $query->where("item_name", "like", "%$keyword%");
                })
                ->when($request->itemCategory, function($query, $itemCategory) {
                    $query->where('item_category_id', $itemCategory);
                }, function($query) {
                    $query->whereNull('item_category_id');
                })
                ->get();
            if($item->isNotEmpty()) {

                return response()->json([
                    'results' => $item
                ], 200);
            }


            return response()->json([], 200);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
        }
    }
}
