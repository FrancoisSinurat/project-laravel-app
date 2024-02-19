<?php

namespace App\Http\Controllers;

use App\Models\BidangCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;


class BidangCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:bidang-list', ['only' => ['index']]);
        $this->middleware('permission:bidang-create', ['only' => ['store']]);
        $this->middleware('permission:bidang-edit', ['only' => ['update']]);
        $this->middleware('permission:bidang-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $bidang = BidangCategory::query();
            return DataTables::of($bidang)->make();
        }
        return view('bidang-category.index');
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
            'bidang_category_name' => 'required|unique:bidang_categories,bidang_category_name,NULL,NULL,deleted_at,NULL',
            'bidang_category_code' => 'required|unique:bidang_categories,bidang_category_code,NULL,NULL,deleted_at,NULL',
        ],
        [
            'bidang_category_name.unique' => 'Nama bidang sudah digunakan',
            'bidang_category_code.unique' => 'Singkatan bidang sudah digunakan'
        ]);
        BidangCategory::create($request->all());
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
            'bidang_category_name' => "required|unique:bidang_categories,bidang_category_name,$id,bidang_category_id,deleted_at,NULL",
            'bidang_category_singkatan' => "required|unique:bidang_categories,bidang_category_singkatan,$id,bidang_category_id,deleted_at,NULL",
        ],
        [
            'bidang_category_name.unique' => 'Nama bidang sudah digunakan',
            'bidang_category_singkatan.unique' => 'Singkatan bidang sudah digunakan'
        ]);
        BidangCategory::where('bidang_category_id', $id)->update($request->all());
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BidangCategory::where('bidang_category_id', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);
    }


    public function ajax(Request $request)
    {
        try {
            $bidang = BidangCategory::select('bidang_category_id', 'bidang_category_name')
                ->when($request->search, function($query, $keyword) {
                    $query->where("bidang_category_name", "like", "%$keyword%");
                })
                ->get();
            if($bidang->isNotEmpty()) {

                return response()->json([
                    'results' => $bidang
                ], 200);
            }


            return response()->json([], 200);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
        }
    }
}

