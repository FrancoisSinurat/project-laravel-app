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
            'item_code' => 'required|unique:items,item_code,NULL,NULL,deleted_at,NULL',
            'item_category_id' => 'required',
        ],
        [
            'item_name.unique' => 'Nama jenis barang sudah digunakan',
            'item_code.unique' => 'Kode jenis barang sudah digunakan'
        ]);
        Item::create($request->all());
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
        Item::where('item_id', $id)->update($request->all());
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
}
