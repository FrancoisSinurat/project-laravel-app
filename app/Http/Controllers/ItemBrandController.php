<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class ItemBrandController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:satuan-list', ['only' => ['index']]);
        $this->middleware('permission:satuan-create', ['only' => ['store']]);
        $this->middleware('permission:satuan-edit', ['only' => ['update']]);
        $this->middleware('permission:satuan-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            // $item = ItemBrand::query()->with('item_category');
            $item = ItemBrand::query();
            return DataTables::of($item)->make();
        }
        $itemCategory = Item::get();
        return view('brand.index', compact('itemCategory'));
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
            'item_brand_name' => 'required|unique:item_brands,item_brand_name,NULL,NULL,deleted_at,NULL',
            'item_id' => 'required',
        ],
        [
            'item_brand_name.unique' => 'Nama Merk sudah digunakan'
        ]);
        try {
            $input = $request->all();
            ItemBrand::create($input);
            $menu = ItemBrand::get();
            if (count($menu) > 0) Session::put('categories', $menu);
            if (count($menu) == 0) Session::put('categories', []);
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
            'item_brand_name' => "required|unique:item_brands,item_brand_name,$id,item_brand_id,deleted_at,NULL",
            'item_id' => 'required',
        ],
        [
            'item_brand_name.unique' => 'Nama Merk sudah digunakan'
            // 'item_id.unique' => 'ID Merk sudah digunakan'
        ]);
        $input = $request->all();
        try {
            ItemBrand::where('item_brand_id', $id)->update($input);
            $menu = ItemBrand::get();
            if (count($menu) > 0) Session::put('categories', $menu);
            if (count($menu) == 0) Session::put('categories', []);
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
            ItemBrand::where('item_brand_id', $id)->delete();
            $menu = ItemBrand::get();
            if (count($menu) > 0) Session::put('categories', $menu);
            if (count($menu) == 0) Session::put('categories', []);
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

    public function ajax(Request $request)
    {
        try {
            $itemBrands = ItemBrand::select('item_barand_id', 'item_id', 'item_brand_name')
                ->when($request->search, function($query, $keyword) {
                    $query->where("item_brand_name", "like", "%$keyword%");
                })
                ->when($request->itemCategory, function($query, $itemCategory) {
                    $query->where('item_id', $itemCategory);
                }, function($query) {
                    $query->whereNull('item_id');
                })
                ->get();
            if($itemCategories->isNotEmpty()) {

                return response()->json([
                    'results' => $itemCategories
                ], 200);
            }


            return response()->json([], 200);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
        }
    }


}
