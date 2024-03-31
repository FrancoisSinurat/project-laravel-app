<?php

namespace App\Http\Controllers;

use App\Models\SatuanCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;


class SatuanCategoryController extends Controller
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
            $satuan = SatuanCategory::query();
            return DataTables::of($satuan)->make();
        }
        return view('satuan-category.index');
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
            'satuan_category_name' => 'required|unique:satuan_categories,satuan_category_name,NULL,NULL,deleted_at,NULL',
        ],
        [
            'satuan_category_name.unique' => 'Nama satuan sudah digunakan',
        ]);
        SatuanCategory::create($request->all());
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
            'satuan_category_name' => "required|unique:satuan_categories,satuan_category_name,$id,satuan_category_id,deleted_at,NULL",
        ],
        [
            'satuan_category_name.unique' => 'Nama satuan sudah digunakan',
        ]);
        SatuanCategory::where('satuan_category_id', $id)->update($request->all());
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        SatuanCategory::where('satuan_category_id', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function ajax(Request $request)
    {
        try {
            $satuan = SatuanCategory::select('satuan_category_id', 'satuan_category_name')
                ->when($request->search, function($query, $keyword) {
                    $keyword = strtolower($keyword);
                    $query->whereRaw('LOWER(satuan_category_name) LIKE ? ',['%'.$keyword.'%']);

                })
                ->limit(10)
                ->get();
            if($satuan->isNotEmpty()) {

                return response()->json([
                    'results' => $satuan
                ], 200);
            }


            return response()->json([], 200);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
        }
    }
}
