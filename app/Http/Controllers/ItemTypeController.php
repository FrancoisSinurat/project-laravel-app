<?php

namespace App\Http\Controllers;

use App\Models\ItemBrand;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class ItemTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:kategori-barang-list', ['only' => ['index']]);
        $this->middleware('permission:kategori-barang-create', ['only' => ['store']]);
        $this->middleware('permission:kategori-barang-edit', ['only' => ['update']]);
        $this->middleware('permission:kategori-barang-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $item = ItemType::query()->with('brand');
            return DataTables::of($item)->make();
        }
        $itemBrand = ItemBrand::get();
        return view('item-type.index', compact('itemBrand'));
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
            'item_type_name' => 'required|unique:item_types,item_type_name,NULL,NULL,deleted_at,NULL',
            'item_brand_id' => 'required',
        ],
        [
            'item_type_name.unique' => 'Tipe barang sudah digunakan',
        ]);
        $input = $request->all();
        ItemType::create($input);
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
            'item_type_name' => "required|unique:item_types,item_type_name,$id,item_type_id,deleted_at,NULL",
            'item_brand_id' => 'required',
        ],
        [
            'item_type_name.unique' => 'Tipe barang sudah digunakan',
        ]);
        $input = $request->all();
        ItemType::where('item_type_id', $id)->update($input);
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ItemType::where('item_type_id', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);

    }


    public function ajax(Request $request)
    {
        try {
            $item = ItemType::select('item_type_id', 'item_brand_id', 'item_type_name')
                ->when($request->search, function($query, $keyword) {
                    $query->where("item_type_name", "like", "%$keyword%");
                })
                ->when($request->itemBrand, function($query, $itemBrand) {
                    $query->where('item_brand_id', $itemBrand);
                }, function($query) {
                    $query->whereNull('item_brand_id');
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
