<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ItemCategoryController extends Controller
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
        $icons = config('app.icons');
        $colors = config('app.colors');
        $texts = config('app.texts');
        $colorsBg = config('app.colorsBg');

        if($request->ajax()) {
            $item = ItemCategory::query()->with('asset_category');
            return DataTables::of($item)->make();
        }
        $assetCategory = AssetCategory::get();
        return view('item-category.index', compact('assetCategory','icons','colors','texts','colorsBg'));
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
            'item_category_name' => 'required|unique:item_categories,item_category_name,NULL,NULL,deleted_at,NULL',
            'item_category_code' => 'required|unique:item_categories,item_category_code,NULL,NULL,deleted_at,NULL',
            'item_category_icon' => 'required|unique:item_categories,item_category_icon,NULL,NULL,deleted_at,NULL',
            'item_category_color' => 'required|unique:item_categories,item_category_color,NULL,NULL,deleted_at,NULL',
            'item_category_text' => 'required|unique:item_categories,item_category_text,NULL,NULL,deleted_at,NULL',
            'item_category_color_bg' => 'required|unique:item_categories,item_category_color_bg,NULL,NULL,deleted_at,NULL',
            'asset_category_id' => 'required',
        ],
        [
            'item_category_name.unique' => 'Nama barang sudah digunakan',
            'item_category_code.unique' => 'Kode barang sudah digunakan',
            'item_category_icon.unique' => 'Ikon sudah digunakan',
            'item_category_color.unique' => 'Warna sudah digunakan',
            'item_category_text.unique' => 'Text sudah digunakan',
            'item_category_color_bg.unique' => 'Warna Background sudah digunakan',

        ]);
        try {
            $input = $request->all();
            $input['item_category_code'] = strtoupper($input['item_category_code']);
            ItemCategory::create($input);
            $menu = ItemCategory::with('asset_category')->get();
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
            'item_category_name' => "required|unique:item_categories,item_category_name,$id,item_category_id,deleted_at,NULL",
            'item_category_code' => "required|unique:item_categories,item_category_code,$id,item_category_id,deleted_at,NULL",
            'item_category_icon' => "required|unique:item_categories,item_category_icon,$id,item_category_id,deleted_at,NULL",
            'item_category_color' => "required|unique:item_categories,item_category_color,$id,item_category_id,deleted_at,NULL",
            'item_category_text' => "required|unique:item_categories,item_category_text,$id,item_category_id,deleted_at,NULL",
            'item_category_color_bg' => "required|unique:item_categories,item_category_color_bg,$id,item_category_id,deleted_at,NULL",
            'asset_category_id' => 'required',
        ],
        [
            'item_category_name.unique' => 'Nama barang sudah digunakan',
            'item_category_code.unique' => 'Kode barang sudah digunakan',
            'item_category_icon.unique' => 'Ikon sudah digunakan',
            'item_category_color.unique' => 'Warna sudah digunakan',
            'item_category_text.unique' => 'Text sudah digunakan',
            'item_category_color_bg.unique' => 'Warna Background sudah digunakan',

        ]);
        $input = $request->all();
        $input['item_category_code'] = strtoupper($input['item_category_code']);
        try {
            ItemCategory::where('item_category_id', $id)->update($input);
            $menu = ItemCategory::with('asset_category')->get();
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
            ItemCategory::where('item_category_id', $id)->delete();
            $menu = ItemCategory::get();
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
            $itemCategories = ItemCategory::select('item_category_id', 'asset_category_id', 'item_category_name', 'item_category_code')
                ->when($request->search, function($query, $keyword) {
                    $keyword = strtolower($keyword);
                    $query->whereRaw('LOWER(item_category_name) LIKE ? ',['%'.$keyword.'%']);

                })
                ->when($request->assetCategory, function($query, $assetCategory) {
                    $query->where('asset_category_id', $assetCategory);
                }, function($query) {
                    $query->whereNull('asset_category_id');
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
