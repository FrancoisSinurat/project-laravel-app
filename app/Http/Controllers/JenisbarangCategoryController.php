<?php

namespace App\Http\Controllers;

use App\Models\JenisbarangCategory;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class JenisbarangCategoryController extends Controller
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
            $item = JenisbarangCategory::query()->with('item_category');
            return DataTables::of($item)->make();
        }
        $itemCategory = ItemCategory::get();
        return view('jenisbarang-category.index', compact('itemCategory'));
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
            'jenisbarang_category_name' => 'required|unique:jenisbarang_categories,jenisbarang_category_name,NULL,NULL,deleted_at,NULL',
            'jenisbarang_category_code' => 'required|unique:jenisbarang_categories,jenisbarang_category_code,NULL,NULL,deleted_at,NULL',
            'item_category_id' => 'required',
        ],
        [
            'jenisbarang_category_name.unique' => 'Nama jenis barang sudah digunakan',
            'jenisbarang_category_code.unique' => 'Kode jenis barang sudah digunakan'
        ]);
        try {
            $input = $request->all();
            $input['jenisbarang_category_code'] = strtoupper($input['jenisbarang_category_code']);
            JenisbarangCategory::create($input);
            $menu = JenisbarangCategory::get();
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
            'jenisbarang_category_name' => "required|unique:jenisbarang_categories,jenisbarang_category_name,$id,jenisbarang_category_id,deleted_at,NULL",
            'jenisbarang_category_code' => "required|unique:jenisbarang_categories,jenisbarang_category_code,$id,jenisbarang_category_id,deleted_at,NULL",
            'item_category_id' => 'required',
        ],
        [
            'jenisbarang_category_name.unique' => 'Nama jenis barang sudah digunakan',
            'jenisbarang_category_code.unique' => 'Kode jenis barang sudah digunakan'
        ]);
        $input = $request->all();
        $input['jenisbarang_category_code'] = strtoupper($input['jenisbarang_category_code']);
        try {
            JenisbarangCategory::where('jenisbarang_category_id', $id)->update($input);
            $menu = JenisbarangCategory::get();
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
            JenisbarangCategory::where('jenisbarang_category_id', $id)->delete();
            $menu = JenisbarangCategory::get();
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
}
